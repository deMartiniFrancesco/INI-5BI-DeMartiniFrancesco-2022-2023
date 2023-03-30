package deMartiniFrancesco.projects.demartini_F_ETL_ALUNNI.bin;

import java.io.BufferedReader;
import java.io.File;
import java.io.FileReader;
import java.io.IOException;
import java.sql.*;
import java.text.DateFormat;
import java.text.ParseException;
import java.text.SimpleDateFormat;
import java.util.Arrays;
import java.util.Iterator;
import java.util.List;

class ETL_ALUNNI {

    static final String tableName = "etl_alunni";
    private Connection connection;

    public ETL_ALUNNI() {
        try {
            connection = DriverManager.getConnection(
                    "jdbc:mysql://172.16.1.99:3306/db99999",
                    "ut99999",
                    "pw99999"
            );
            if (existTable(tableName)) {
                dropTable(tableName);
            }
            createTableAlunno();

        } catch (SQLException ex) {
            // handle any errors
            System.out.println("SQLException: " + ex.getMessage());
            System.out.println("SQLState: " + ex.getSQLState());
            System.out.println("VendorError: " + ex.getErrorCode());
        }
    }

    public boolean existTable(String table) throws SQLException {
        DatabaseMetaData metaData = connection.getMetaData();
        ResultSet resultSet = metaData.getTables(null, null, "%", null);
        while (resultSet.next()) {
            if (table.equalsIgnoreCase(resultSet.getString(3))) {
                return true;
            }
        }
        return false;
    }
    public void dropTable(String table) throws SQLException {
        Statement statement = connection.createStatement();
        statement.execute("DROP TABLE " + table + ";");
    }
    public void createTableAlunno() throws SQLException {
        Statement statement = connection.createStatement();
        statement.execute(String.format("""
                CREATE TABLE %s
                (
                matricola               INT NOT NULL,
                cognome                 VARCHAR(45) NOT NULL,
                nome                    VARCHAR(45) NOT NULL,
                residenza               VARCHAR(45),
                classe_next             VARCHAR(45),
                cittadinanza_estesa     VARCHAR(45),
                voto_medio              FLOAT,
                voto_condotta           VARCHAR(45),
                data_nascita            DATE,
                cap                     INT,
                voto_italiano           INT,
                voto_matematica         INT,
                voto_inglese            INT,
                            
                PRIMARY KEY (matricola)
                );
                """, tableName));
        System.out.println("ETL_ALUNNI.createTableAlunno");
    }

    public void loadCsv(String csvFilePath) {
        String sql = String.format("""
                INSERT INTO %s (
                        matricola,
                        cognome,
                        nome,
                        residenza,
                        classe_next,
                        cittadinanza_estesa,
                        voto_medio,
                        voto_condotta,
                        data_nascita,
                        cap,
                        voto_italiano,
                        voto_matematica,
                        voto_inglese
                    )
                VALUES
                    (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);
                """, tableName);

        List<Integer> statementTypes = Arrays.asList(
                Types.INTEGER,
                Types.VARCHAR,
                Types.VARCHAR,
                Types.VARCHAR,
                Types.VARCHAR,
                Types.VARCHAR,
                Types.FLOAT,
                Types.VARCHAR,
                Types.DATE,
                Types.INTEGER,
                Types.INTEGER,
                Types.INTEGER,
                Types.INTEGER
        );

        try {
            PreparedStatement statement = connection.prepareStatement(sql);
            BufferedReader lineReader = new BufferedReader(new FileReader(csvFilePath));
            String lineText;
            lineReader.readLine();
            int correctLine = 0;
            int errorLine = 0;
            while ((lineText = lineReader.readLine()) != null) {
                List<String> data = Arrays.stream(lineText.split(";")).map(String::trim).map(s -> s.replace(",", ".")).toList();

                Iterator<Integer> statementIterator = statementTypes.iterator();
                Iterator<String> dataIterator = data.iterator();
                int cont = 1;
                try {
                    while (statementIterator.hasNext() && dataIterator.hasNext()) {
                        setStatementValue(statement, cont++, statementIterator.next(), dataIterator.next());
                    }
                } catch (Exception e) {
                    e.printStackTrace();
                    errorLine++;
                    continue;
                }
                statement.execute();
                correctLine++;

            }
            lineReader.close();
            System.out.println("correctLine = " + correctLine);
            System.out.println("errorLine = " + errorLine);
        } catch (IOException | SQLException exception) {
            exception.printStackTrace();
        }
    }

    private void setStatementValue(PreparedStatement statement, int index, int sqlType, String data) throws Exception {
        DateFormat sourceFormat = new SimpleDateFormat("dd/MM/yyyy");
        try {
            switch (sqlType) {
                case Types.INTEGER -> statement.setInt(index, Integer.parseInt(data));
                case Types.FLOAT -> statement.setFloat(index, Float.parseFloat(data));
                case Types.DATE -> statement.setDate(index, new Date(sourceFormat.parse(data).getTime()));
                case Types.VARCHAR -> statement.setString(index, data);
            }
        } catch (SQLException | ParseException | NumberFormatException e) {
            if (index <= 4) {
                throw new RuntimeException();
            }
            statement.setNull(index, Types.NULL);
        }
    }
}


class ETL_ALUNNITest {
    public static void main(String[] args) {

        System.out.println("Start");

        //              CALCOLO PATH RELATIVO UNIVERSALE
        //----------------------------------------------------------------------
        String tempPath = new File(
                String.valueOf(ETL_ALUNNI.class.getPackage()).replace("package ", "").replace(".", "/")
        ).getParent();
        String srcPath = "/src/main/java/";
        File uesrPath = new File(System.getProperty("user.dir"));
        String projectPath = uesrPath.getName().equals(tempPath) ?
                uesrPath.getPath() :
                new File(uesrPath.getPath() + srcPath).exists() ?
                        uesrPath.getPath() + srcPath + tempPath :
                        uesrPath.getPath() + tempPath;
        //----------------------------------------------------------------------

        // COSTANTI
        String resourcesPath = projectPath + "/file/";

        ETL_ALUNNI etlAlunni = new ETL_ALUNNI();

        try {
            etlAlunni.loadCsv(resourcesPath + "export_alunni.csv");
        } catch (Exception e) {
            throw new RuntimeException(e);
        }

        System.out.println("End");
    }
}