<?php
class DB_con{
private $connect;
private $password = '';
private $name = "root";
public function __construct(){
    $this->connect = new PDO("mysql:host=localhost;dbname=users_api",$this->name,$this->password);

}

 public function fetchdata()
    {
        $sql = "SELECT id, name, email FROM users";

        $stmt = $this->connect->query($sql);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create($name, $email)
{
    $sql = "INSERT INTO users (name, email) VALUES (?, ?)";

    $stmt = $this->connect->prepare($sql);

    return $stmt->execute([$name, $email]);
}

public function delete($id)
{
    $sql = "DELETE FROM users WHERE id = ?";

    $stmt = $this->connect->prepare($sql);

    return $stmt->execute([$id]);
}

public function update($id, $name, $email)
{
    $sql = "UPDATE users SET name = ?, email = ? WHERE id = ?";

    $stmt = $this->connect->prepare($sql);

    return $stmt->execute([$name, $email, $id]);
}
}

?>