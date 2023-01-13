package deMartiniFrancesco.projects.demartini_F_ETL_ALUNNI.bin;

import javax.swing.text.DateFormatter;
import java.io.BufferedReader;
import java.io.File;
import java.io.FileReader;
import java.io.IOException;
import java.sql.*;
import java.text.ParseException;
import java.text.SimpleDateFormat;
import java.util.Arrays;

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
            createTable(tableName);

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

    private void createTable(String table) throws SQLException {
        Statement statement = connection.createStatement();
        statement.execute("CREATE TABLE " + table + """
                (
                   matricola int NOT NULL ,
                   cognome varchar(45) NOT NULL ,
                   nome varchar(45) NOT NULL ,
                   residenza varchar(45) ,
                   class_next varchar(45) ,
                   cittadinanza_estesa varchar(45) ,
                   voto_medio float ,
                   voto_condotta int ,
                   data_nascita DATE ,
                   cap int ,
                   voto_italiano varchar(3) ,
                   voto_matematica varchar(3) ,
                   voto_inglese varchar(3) ,
                    
                  PRIMARY KEY (matricola)
                  );
                """);
        System.out.println("ETL_ALUNNI.createTable");
    }


    public void loadLezioniCsv(String csvFilePath) throws SQLException, IOException, ParseException {

        String sql =  "INSERT INTO " + tableName + """
        (
            matricola,
            cognome,
            nome,
            residenza,
            class_next,
            cittadinanza_estesa,
            voto_medio,
            voto_condotta,
            data_nascita,
            cap,
            voto_italiano,
            voto_matematica,
            voto_inglese
            
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        """;
        PreparedStatement statement = connection.prepareStatement(sql);

        BufferedReader lineReader = new BufferedReader(new FileReader(csvFilePath));
        String lineText = null;
        int count = 0;
        SimpleDateFormat simpleDateFormat = new SimpleDateFormat("dd/MM/yyyy");
        lineReader.readLine(); // skip header line

        while ((lineText = lineReader.readLine()) != null) {
            String[] data = Arrays.stream(lineText.split(";")).map(String::trim).toArray(String[]::new);
            System.out.println("data = " + Arrays.toString(data));

            int matricola = Integer.parseInt(data[0]);
            String cognome = data[1];
            String nome = data[2];
            String residenza = data[3];
            String class_next = data[4];
            String cittadinanza_estesa = data[5];
            String voto_medio = data[6];
            String voto_condotta = data[7];
            Date data_nascita = new Date(simpleDateFormat.parse(data[8]).getTime());
            int cap = Integer.parseInt(data[9]);
            String voto_italiano = data[10];
            String voto_matematica = data[11];
            String voto_inglese = data[12];

            statement.setInt(1, matricola);
            statement.setString(2, cognome);
            statement.setString(3, nome);
            statement.setString(4, residenza);
            statement.setString(5, class_next);
            statement.setString(6, cittadinanza_estesa);
            statement.setString(7, voto_medio);
            statement.setString(8, voto_condotta);
            statement.setDate(9, data_nascita);
            statement.setInt(10, cap);
            statement.setString(11, voto_italiano);
            statement.setString(12, voto_matematica);
            statement.setString(13, voto_inglese);

            statement.addBatch();
        }

        lineReader.close();
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
            etlAlunni.loadLezioniCsv(resourcesPath + "export_alunni.csv");
        } catch (SQLException | IOException | ParseException e) {
            throw new RuntimeException(e);
        }

        System.out.println("End");
    }
}