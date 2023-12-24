# import the wb module
from wb import DefineModule, wbinputs
# import the grt module
import grt
# import the mforms module for GUI stuff
import mforms

# define this Python module as a GRT module
ModuleInfo = DefineModule(name= "MySQLPDO", author= "Yours Truly", version="1.0")

@ModuleInfo.plugin("info.yourstruly.wb.mysqlpdo", caption= "MySQL PDO (Connect to Server)", input= [wbinputs.currentSQLEditor()], pluginMenu= "SQL/Utilities")
@ModuleInfo.export(grt.INT, grt.classes.db_query_Editor)

def mysqlpdo(editor):
    """Copies PHP code to connect to the active MySQL connection using PDO, to the clipboard.
    """
    # Values depend on the active connection type
    if editor.connection:
        conn = editor.connection

        if conn.driver.name == "MysqlNativeSocket":
            params = {
            "host" : "",
            "port" : "",
            "user" : conn.parameterValues["userName"],
            "socket" : conn.parameterValues["socket"],
            "dbname" : editor.defaultSchema,
            "dsn" : "mysql:unix_socket={$socket};dbname={$dbname}"
            }
        else:
            params = {
            "host" : conn.parameterValues["hostName"],
            "port" : conn.parameterValues["port"] if conn.parameterValues["port"] else 3306,
            "user" : conn.parameterValues["userName"],
            "socket" : "",
            "dbname" : editor.defaultSchema,
            "dsn" : "mysql:host={$host};port={$port};dbname={$dbname}"
            }
        text = """$host="%(host)s";
$port=%(port)s;
$socket="%(socket)s";
$user="%(user)s";
$password="";
$dbname="%(dbname)s";

try {
    $dbh = new PDO("%(dsn)s", $user, $password));
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}

""" % params
        mforms.Utilities.set_clipboard_text(text)
        mforms.App.get().set_status_text("Copied PHP code to clipboard")
    return 0