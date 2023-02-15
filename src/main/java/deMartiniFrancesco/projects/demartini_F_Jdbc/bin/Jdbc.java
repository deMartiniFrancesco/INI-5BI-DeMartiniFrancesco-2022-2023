package deMartiniFrancesco.projects.demartini_F_Jdbc.bin;

import java.io.*;
import java.sql.*;
import java.util.Arrays;

class Jdbc {
    static String LEZIONE = "lezione_deMartini";
    static String DOCENTE = "docente_deMartini";

    private Connection connection;

    public Jdbc() {
        try {
            connection = DriverManager.getConnection(
                    "jdbc:mysql://172.16.1.99:3306/db99999",
                    "ut99999",
                    "pw99999"
            );
            if (existTable(DOCENTE)) {
                System.out.println("exist " + DOCENTE);
                dropTable(DOCENTE);
            }
            createDocenteTable();
            if (existTable(LEZIONE)) {
                System.out.println("exist " + LEZIONE);
                dropTable(LEZIONE);
            }
            createLezioiTable();

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

    public void createLezioiTable() throws SQLException {
        Statement statement = connection.createStatement();
        statement.execute("CREATE TABLE " + LEZIONE + """
                (
                 "id"           bigint NOT NULL AUTO_INCREMENT ,
                 "classe"       varchar(45) NULL ,
                 "docente_id"   bigint NOT NULL ,
                 "docente_id_2" bigint NOT NULL ,
                 "materia"      varchar(45) NOT NULL ,
                 "aula"         varchar(45) NULL ,
                 "giorno"       int NOT NULL ,
                 "ora"          int NOT NULL ,
                                
                PRIMARY KEY ("id"),
                KEY "FK_docente" ("docente_id"),
                CONSTRAINT "FK_2" FOREIGN KEY "FK_docente" ("docente_id") REFERENCES "docente_deMartini" ("docente_id"),
                KEY "FK_docente_2" ("docente_id_2"),
                CONSTRAINT "FK_1" FOREIGN KEY "FK_docente_2" ("docente_id_2") REFERENCES "docente_deMartini" ("docente_id")
                );
                """);
        System.out.println("Jdbc.createLezioiTable");
    }

    public void createDocenteTable() throws SQLException {
        Statement statement = connection.createStatement();
        statement.execute("CREATE TABLE " + DOCENTE + """
                (
                   "docente_id"   bigint NOT NULL ,
                   "nome_cognome" varchar(45) NOT NULL ,
                  
                  PRIMARY KEY ("docente_id")
                  );
                """);
        System.out.println("Jdbc.createDocenteTable");
    }


    public void loadLezioniCsv(String csvFilePath) throws SQLException, IOException {

        String sql = "INSERT INTO review (course_name, student_name, timestamp, rating, comment) VALUES (?, ?, ?, ?, ?)";
        PreparedStatement statement = connection.prepareStatement(sql);

        BufferedReader lineReader = new BufferedReader(new FileReader(csvFilePath));
        String lineText = null;
        int count = 0;

        lineReader.readLine(); // skip header line

        while ((lineText = lineReader.readLine()) != null) {
            String[] data = Arrays.stream(lineText.split(";")).map(String::trim).toArray(String[]::new);
            String deocente1 = data[0];
            String classe = data[1];
            String deocente2 = data[2];
            String materia = data[3];
            String aula = data[4];
            int giorno = Integer.parseInt(data[5]);
            int ora= Integer.parseInt(data[6]);

//            statement.setString(1, courseName);
//            statement.setString(2, studentName);
//
//            Timestamp sqlTimestamp = Timestamp.valueOf(timestamp);
//            statement.setTimestamp(3, sqlTimestamp);
//
//            float fRating = Float.parseFloat(rating);
//            statement.setFloat(4, fRating);
//
//            statement.setString(5, comment);

            statement.addBatch();
        }

        lineReader.close();
    }
}

class JdbcTest {
    public static void main(String[] args) throws SQLException {

        System.out.println("Start");

        //              CALCOLO PATH RELATIVO UNIVERSALE
        //----------------------------------------------------------------------
        String tempPath = new File(
                String.valueOf(Jdbc.class.getPackage()).replace("package ", "").replace(".", "/")
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

        Jdbc jdbc = new Jdbc();

        try {
            jdbc.loadLezioniCsv(resourcesPath + "GPU001.csv");
        } catch (IOException e) {
            throw new RuntimeException(e);
        }

        System.out.println("End");

    }
}