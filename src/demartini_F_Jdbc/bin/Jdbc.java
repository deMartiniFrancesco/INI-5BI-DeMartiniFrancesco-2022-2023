package demartini_F_JDBC.bin;

import java.io.File;
import java.sql.*;

class Jdbc {
    static String LEZIONE = "lezione_deMartini";
    static String DOCENTE = "docente_deMartini";

    private Connection connection;

    public Jdbc() {
        try {
            connection = DriverManager.getConnection("jdbc:mysql://172.16.1.99:3306/db99999", "ut99999", "pw99999");
            if (!notExistTable(connection, "lezioni_deMartini")) {
                System.out.println("exist");
                dropTable(connection, "lezioni_deMartini");
            }
            if (notExistTable(connection, LEZIONE)) {
                createLezioiTable(connection);
            }
            if (notExistTable(connection, DOCENTE)) {
                createDocenteTable(connection);
            }

        } catch (SQLException ex) {
            // handle any errors
            System.out.println("SQLException: " + ex.getMessage());
            System.out.println("SQLState: " + ex.getSQLState());
            System.out.println("VendorError: " + ex.getErrorCode());
        }


    }

    public static boolean notExistTable(Connection connection, String table) throws SQLException {
        System.out.println("Jdbc.notExistTable");
        DatabaseMetaData metaData = connection.getMetaData();
        ResultSet resultSet = metaData.getTables(null, null, "%", null);
        while (resultSet.next()) {
            if (table.equalsIgnoreCase(resultSet.getString(3))) {
                return false;
            }
        }
        return true;
    }


    public void dropTable(Connection connection, String table) throws SQLException {
        Statement statement = connection.createStatement();
        statement.execute("DROP TABLE " + table + ";");
        System.out.println("Jdbc.dropTable");
    }

    public void createLezioiTable(Connection connection) throws SQLException {
        Statement statement = connection.createStatement();
        statement.executeUpdate("CREATE TABLE `" + LEZIONE + "` ("
                + "  `id` bigint(20) NOT NULL primary key,"
                + "  `aula` varchar(30) DEFAULT NULL,"
                + "  `materia` varchar(20) NOT NULL,"
                + "  `classe` varchar(20),"
                + "  `giorno` int(20)  NOT NULL,"
                + "  `ora` int(20)  NOT NULL"
                + ") ENGINE=InnoDB DEFAULT CHARSET=latin1");
        System.out.println("Jdbc.createLezioiTable");
    }

    public void createDocenteTable(Connection connection) throws SQLException {
        Statement statement = connection.createStatement();
        statement.executeUpdate("CREATE TABLE `" + DOCENTE + "` ("
                + "  `id` bigint(20) NOT NULL primary key,"
                + "  `nome_cognome` varchar(40) NOT NULL"
                + ") ENGINE=InnoDB DEFAULT CHARSET=latin1");
        System.out.println("Jdbc.createDocenteTable");
    }


}

class JdbcTest {
    public static void main(String[] args) {

        System.out.println("Start");

        //              CALCOLO PATH RELATIVO UNIVERSALE
        //----------------------------------------------------------------------
        String tempPath = new File(
                String.valueOf(Jdbc.class.getPackage()).replace("package ", "").replace(".", "/")
        ).getParent();
        File uesrPath = new File(System.getProperty("user.dir"));
        String projectPath = uesrPath.getName().equals(tempPath) ?
                uesrPath.getPath() :
                new File(uesrPath.getPath() + "/src").exists() ?
                        uesrPath.getPath() + "/src/" + tempPath :
                        uesrPath.getPath() + tempPath;
        //----------------------------------------------------------------------

        // COSTANTI
        String resursesPath = "/file/";

        Jdbc jdbc = new Jdbc();

        System.out.println("End");

    }
}