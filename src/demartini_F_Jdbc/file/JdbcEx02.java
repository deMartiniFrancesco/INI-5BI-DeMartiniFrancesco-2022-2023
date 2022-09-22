package demartini_F_JDBC.file;

import java.sql.*;
import java.util.Scanner;

/**
 * The type Jdbc ex 02.
 */
public class JdbcEx02 {

    /**
     * View table.
     *
     * @param connection the connection
     * @throws SQLException the sql exception
     */
    public static void viewTable(Connection connection) throws SQLException {
        Statement statement = connection.createStatement();
        ResultSet resultSet = statement.executeQuery("SELECT * FROM amici");

        while (resultSet.next()) {
            System.out.println(resultSet.getInt(1)
                    + "  " + resultSet.getString(2)
                    + "  " + resultSet.getString("cognome")
            );
        }
        statement.close();
    }

    /**
     * Exist table boolean.
     *
     * @param connection the connection
     * @param table      the table
     * @return the boolean
     * @throws SQLException the sql exception
     */
    public static boolean existTable(Connection connection, String table) throws SQLException {
        DatabaseMetaData metaData = connection.getMetaData();
        ResultSet resultSet = metaData.getTables(null, null, "%", null);
        while (resultSet.next()) {
            if (table.equalsIgnoreCase(resultSet.getString(3))) {
                return true;
            }
        }
        return false;
    }

    /**
     * Create table int.
     *
     * @param connection the connection
     * @return the int
     * @throws SQLException the sql exception
     */
    public static int createTable(Connection connection) throws SQLException {
        Statement statement = connection.createStatement();
        return statement.executeUpdate("CREATE TABLE `amici` ("
                + "  `id` bigint(20) UNSIGNED NOT NULL auto_increment primary key,"
                + "  `nome` varchar(30) DEFAULT NULL,"
                + "  `cognome` varchar(20) NOT NULL"
                + ") ENGINE=InnoDB DEFAULT CHARSET=latin1");
    }

    public static int insertTab01(Connection connection, String name, String surname) throws SQLException {
        Statement statement = connection.createStatement();

        return statement.executeUpdate(
                "insert into amici (nome,cognome) values('"
                        + name + "','"
                        + surname + "')"
        );
    }

    /**
     * Insert into table int.
     *
     * @param connection the connection
     * @param name       the name
     * @param surname    the surname
     * @return the int
     * @throws SQLException the sql exception
     */
    public static int insertIntoTable(Connection connection, String name, String surname) throws SQLException {
        String insertTableSQL = "INSERT INTO amici (nome,cognome)"
                + "values (?,?)";
        PreparedStatement statement = connection.prepareStatement(insertTableSQL);
        statement.setString(1, name);
        statement.setString(2, surname);

        return statement.executeUpdate();
    }

    /**
     * Modify table int.
     *
     * @param connection the connection
     * @param id         the id
     * @param name       the name
     * @param surname    the surname
     * @return the int
     * @throws SQLException the sql exception
     */
    public static int modifyTable(Connection connection, int id, String name, String surname) throws SQLException {
        String updateSQL = "update amici set nome=?,cognome=? where id=?";
        PreparedStatement statement = connection.prepareStatement(updateSQL);
        statement.setString(1, name);
        statement.setString(2, surname);
        statement.setInt(3, id);

        return statement.executeUpdate();
    }

    /**
     * Result set to vector string [ ].
     *
     * @param resultSet the result set
     * @return the string [ ]
     * @throws SQLException the sql exception
     */
    public static String[] resultSetToVector(ResultSet resultSet) throws SQLException {
        String[] strings = new String[resultSet.getMetaData().getColumnCount()];
        for (int i = 0; i < strings.length; i++)
            strings[i] = resultSet.getString(i);
        return strings;
    }


    /**
     * The entry point of application.
     *
     * @param arg the input arguments
     */
    public static void main(String[] arg) {
        Scanner scanner = new Scanner(System.in);
        Connection connection;
        try {
            connection = DriverManager.getConnection(
                    "jdbc:mysql://172.16.1.99/db99999?user=ut99999&password=pw99999");

            boolean cont = true;
            while (cont) {
                if (existTable(connection, "amici")) {
                    System.out.println("Tabella esistente");
                } else {
                    System.out.println("Tabella inesistente");
                }

                System.out.print("0 Uscita\n1 Crea Tabella\n2 visualizza\n3 Aggiungi\n4 Mod Tabella\n");
                String line = scanner.nextLine();

                int result, code;
                String name, surname;

                switch (line.charAt(0)) {
                    case '0' -> cont = false;
                    case '2' -> viewTable(connection);
                    case '3' -> {
                        System.out.print("Nome -->");
                        name = scanner.nextLine();
                        System.out.print("Cognome -->");
                        surname = scanner.nextLine();
                        result = insertIntoTable(connection, name, surname);
                        System.out.println("risultato " + result);
                    }
                    case '4' -> {
                        System.out.print("Codice -->");
                        code = Integer.parseInt(scanner.nextLine());
                        System.out.print("Nome -->");
                        name = scanner.nextLine();
                        System.out.print("Cognome -->");
                        surname = scanner.nextLine();
                        result = modifyTable(connection, code, name, surname);
                        System.out.println("risultato " + result);
                    }
                    case '1' -> createTable(connection);
                }
            }
        } catch (SQLException ex) {
            // handle any errors
            System.out.println("SQLException: " + ex.getMessage());
            System.out.println("SQLState: " + ex.getSQLState());
            System.out.println("VendorError: " + ex.getErrorCode());
        }
    }
}
