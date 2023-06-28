<?php
class Member
{

    private $ds;
    private $tablename;

    function __construct()
    {
        require_once __DIR__ . '/../lib/DataSource.php';
        $this->ds = new DataSource();
        $this->tablename = "tbl_member";
    }


    /**
     * check if entity exists
     *
     * @param string $attribute
     * @param string $entity
     * @return boolean
     */
    public function isExists($attribute, $entity)
    {
        $query = 'SELECT * FROM ' . $this->tablename . ' where ' . $attribute . ' = ?';
        $paramType = 's';
        $paramValue = array(
            $entity
        );
        $resultArray = $this->ds->select($query, $paramType, $paramValue);

        if (!is_array($resultArray))
            return false;

        if (count($resultArray) > 0)
            return true;

        return false;
    }


    /**
     * to signup / register a user
     *
     * @return string[] registration status message
     */
    public function registerMember()
    {
        $memberName = $_POST["username"];
        $memberPassword = $_POST["password"];
        $memberEmail = $_POST["email"];

        $isUsernameExists = $this->isExists("username", $memberName);
        if ($isUsernameExists)
            return array(
                "status" => "error",
                "message" => "Username already exists."
            );


        $isEmailExists = $this->isExists("email", $memberEmail);
        if ($isEmailExists)
            return array(
                "status" => "error",
                "message" => "Email already exists."
            );


        if (empty($memberPassword))
            return array(
                "status" => "error",
                "message" => "Don't leave blank your password."
            );

        $hashedPassword = password_hash($memberPassword, PASSWORD_DEFAULT);
        $query = 'INSERT INTO ' . $this->tablename . ' (username, password, email) VALUES (?, ?, ?)';
        $paramType = 'sss';
        $paramValue = array(
            $memberName,
            $hashedPassword,
            $memberEmail
        );
        $memberId = $this->ds->insert($query, $paramType, $paramValue);

        if (!empty($memberId)) {
            return array(
                "status" => "success",
                "message" => "You have registered successfully."
            );
        }

        return array(
            "status" => "error",
            "message" => "Your network is good, but there are problems on our side."
        );
    }

    public function getMemberDetails($memberName)
    {
        $query = 'SELECT * FROM ' . $this->tablename . ' where username = ?';
        $paramType = 's';
        $paramValue = array(
            $memberName
        );
        $memberRecord = $this->ds->select($query, $paramType, $paramValue);
        return $memberRecord;
    }

    /**
     * user login
     *
     * @return string
     */
    public function loginMember()
    {
        if (empty($_POST["username"]))
            return "Please enter your username";

        if (empty($_POST["password"]))
            return "Please enter your password";

        $memberRecord = $this->getMemberDetails($_POST["username"]);

        if (empty($memberRecord))
            return "Invalid username or password.";


        $password = $_POST["password"];

        $hashedPassword = $memberRecord[0]["password"];

        if (!password_verify($password, $hashedPassword))
            return "Invalid username or password.";


        session_start();
        $_SESSION["username"] = $memberRecord[0]["username"];
        session_write_close();
        $url = "../view/home.view.php";
        header("Location: $url");

        return 0;


    }
}