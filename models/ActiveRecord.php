<?php

namespace Model;

class ActiveRecord
{

    /**
     * Connection with the database, this allows to perform all the queries on the database.
     */
    protected static $database;

    /**
     * Name of the entity in the database.
     */
    protected static $tableName = '';

    /**
     * Primary key of the entity
     */
    protected static $primaryKey = 'id';

    /**
     * Array containing the names of all the attributes of the entity in the database
     */
    protected static $dbColumns = [];

    /**
     * Array containing the names of all attributes of the entity in the database.
     */
    protected static $alerts = [];

    /**
     * This value is assigned automatically in /includes/app.php
     */
    public static function setdbConnection($dbConnection)
    {
        self::$database = $dbConnection;
    }

    /**
     * Adds an alert to the alerts array of the entity.
     * @param string The type of the alert that it is stored
     * @param string The content of the alert
     */
    public static function addAlert($type, $message)
    {
        static::$alerts[$type][] = $message;
    }

    /**
     * Returns a reference of the alerts array of the entity
     * 
     * @return array the reference to the alert associative array
     */
    public static function getAlerts()
    {
        return static::$alerts;
    }

    /**
     * Validates the data of the entity.
     * 
     * @return array the alerts array with the generated alerts from the validation process
     */
    public function validateData()
    {
        static::$alerts = [];
        return static::$alerts;
    }


    /**
     * Executes a given query and returns the result in array form.
     * 
     * @param string $query The query to the database in string.
     * 
     * @return array an associative array with the response of the query
     */
    public static function executeQuery($query)
    {
        // Consultar la base de datos
        $result = self::$database->query($query);

        // Iterar los resultados
        $array = [];
        while ($register = $result->fetch_assoc()) {
            $array[] = static::createObject($register);
        }

        // liberar la memoria
        $result->free();

        // retornar los resultados
        return $array;
    }

    /**
     * Returns an instance of the entity given the database info.
     * 
     * @param array $register the data of the database
     * 
     * @return array The instance of the class entity.
     */
    protected static function createObject(array $register)
    {
        $objeto = new static;

        foreach ($register as $key => $value) {
            if (property_exists($objeto, $key)) {
                $objeto->$key = $value;
            }
        }
        return $objeto;
    }

    /**
     * Returns an array of the registers sorted by an specific attribute. 
     * By default returns all the registers sorted by the given attribute in ascendant form
     * 
     * @param string $attribute The attribute in which is going to be sorted the registers.
     * @param string $order The order in which the attributes can be sorted ('ASC' or 'DESC').
     * @param int $limit The amount of registers that it should return.
     */
    public static function getSortedBy(string $attribute, string $order = 'ASC', int $limit = 0)
    {
        $query = "SELECT * FROM " . static::$tableName . " ORDER BY $attribute $order";

        if ($limit === 0) $query .= " LIMIT $limit";

        $result = self::executeQuery($query);
        return $result;
    }

    /**
     * Returns an array with all the attribute names of the entity.
     * 
     * @return array Array with all the names of the entity.
     */
    public function getAttributes()
    {
        $attributes = [];
        foreach (static::$dbColumns as $column) {
            if ($column !== 'id') {
                $attributes[$column] = $this->$column;
            }
        }
        return $attributes;
    }

    /**
     * Sanitizes the entity attributes data.
     * 
     * @return array The sanitized attributes data of the entity.
     */
    public function sanitizeData()
    {
        $attributes = $this->getAttributes();
        $sanitizedAttributes = [];
        foreach ($attributes as $attributeName => $attributeData) {
            $sanitizedAttributes[$attributeName] = self::$database->escape_string($attributeData);
        }
        return $sanitizedAttributes;
    }

    /**
     * Sincronices an entity instance with the given data.
     * 
     * @param array $data an associative array with the new data to assign on the entity object
     */
    public function sincroniceEntity(array $data = [])
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key) && !is_null($value)) {
                $this->$key = $value;
            }
        }
    }

    /**
     * Retrieves a given amount of registers of the entity in the database sorted by its primary key.
     * 
     * @param string $order The order form of the register, it can be 'ASC' or 'DESC'
     * @param int $limit The amount of registers that should be retrieved, by default returns all the registers.
     * 
     * @return array The result registers of the query
     */
    public static function get(string $order = 'ASC', int $limit = 0)
    {
        $query = "SELECT * FROM " . static::$tableName . " ORDER BY " . static::$primaryKey . " $order";
        
        if ($limit === 0) $query .= " LIMIT $limit";

        $result = self::executeQuery($query);
        return $result;
    }

    /**
     * Returns the first register that matches with the given id.
     * 
     * @param int $id
     * 
     * @return array|null the found register in array shape or null if nothing found
     */
    public static function findById(int $id)
    {
        $query = "SELECT * FROM " . static::$tableName  . " WHERE id = $id LIMIT 1";
        $result = self::executeQuery($query);
        return array_shift($result);
    }

    /**
     * Function for pagination. Returns the registers for a page given an amount of registers per page and an offset.
     * 
     * @param int $registersPerPage The amount of registers to be retrieved from the db.
     * @param int $offset the offset to be applied to the query.
     * 
     * @return array an associative array with the registers obtained
     */
    public static function paginate($registersPerPage, $offset)
    {
        $query = "SELECT * FROM " . static::$tableName . " LIMIT $registersPerPage OFFSET $offset";
        $result = self::executeQuery($query);
        return $result;
    }


    /**
     * Returns the first register that matches a given value to a determined attribute
     * 
     * @param string $attribute The attribute to which the search is to be applied
     * @param string $value the value with which the attribute must be matched
     * 
     * @return array|null the first record of the entity that matches the given values or null if none matches.
     */
    public static function where(string $attribute, string $value)
    {
        $query = "SELECT * FROM " . static::$tableName . " WHERE $attribute = '$value' LIMIT 1";
        $result = self::executeQuery($query);
        return array_shift($result);
    }

    /**
     * Returns all the records which attributes match with the specified values.
     * 
     * @param array $searchData An associative array which specifies the desired values that the attributes must have.
     * 
     * @return array|null All the records that match with the given searchData or null if none are found.
     */
    public static function whereArray($searchData = [])
    {
        $query = "SELECT * FROM " . static::$tableName . " WHERE ";
        foreach ($searchData as $key => $value) {
            if ($key === array_key_last($searchData)) {
                $query .= "$key = '$value' ";
            } else {
                $query .= "$key = '$value' AND ";
            }
        }
        $result = self::executeQuery($query);
        return $result;
    }

    /**
     * Returns the total number of records which specified attribute matches with the specified value
     * 
     * @param string $attribute The attribute to filter the records with
     * @param string $value The value that the attribute of the record must have
     */
    public static function total($attribute = "", $value = ''): int
    {
        $query = 'SELECT COUNT(*) FROM ' . static::$tableName;
        if ($attribute) {
            $query .= " WHERE $attribute = '$value'";
        }
        $result = self::$database->query($query);
        $total = $result->fetch_array();
        return array_shift($total);
    }

    /**
     * Creates a register on the database with the current values of the instance attributes.
     * 
     * @return array an associative array with two keys:
     * [
     * "resultado" => The result of the query,
     * "id" => The id of the new created record
     * ]
     */
    public function create()
    {
        // Sanitizar los datos
        $attributes = $this->sanitizeData();

        // Insertar en la base de datos
        $query = " INSERT INTO " . static::$tableName . " ( ";
        $query .= join(', ', array_keys($attributes));
        $query .= " ) VALUES (' ";
        $query .= join("', '", array_values($attributes));
        $query .= " ') ";

        // debuguear($query); // Descomentar si no te funciona algo

        // Resultado de la consulta
        $result = self::$database->query($query);
        return [
            'resultado' =>  $result,
            'id' => self::$database->insert_id
        ];
    }

    // Actualizar el register
    public function update()
    {
        // Sanitizar los datos
        $atributos = $this->sanitizeData();

        // Iterar para ir agregando cada campo de la BD
        $valores = [];
        foreach ($atributos as $key => $value) {
            $valores[] = "{$key}='{$value}'";
        }

        // Consulta SQL
        $query = "UPDATE " . static::$tableName . " SET ";
        $query .=  join(', ', $valores);
        $query .= " WHERE id = '" . self::$database->escape_string(self::$primaryKey) . "' ";
        $query .= " LIMIT 1 ";

        // Actualizar BD
        $result = self::$database->query($query);
        return $result;
    }

    // Eliminar un register por su ID
    public function delete()
    {
        
        $query = "DELETE FROM "  . static::$tableName . " WHERE id = " . $this->id;
        $result = self::$database->query($query);
        return $result;
    }

    public static function deleteAll(){
       // Borra todos los registros de la tabla
        $query = "DELETE FROM " . static::$tableName;
        $result1 = self::$database->query($query);

        // Resetea el contador de autoincremento
        $result2 = self::resetAutoIncrement();

        if ($result1 && $result2) {
            return true; // Borrado y reinicio exitoso
        } else {
            return false; // Hubo un error en al menos una de las consultas
        }

    }

    public static function resetAutoIncrement(){
        // Resetea el contador de autoincremento
        $query = "ALTER TABLE " . static::$tableName . " AUTO_INCREMENT = 1";
        $result = self::$database->query($query);
        return $result;
    }

    public function save() {
        $result = '';
        if(!is_null($this->id)) {
            // actualizar
            $result = $this->update();
        } else {
            // Creando un nuevo registro
            $result = $this->create();
        }
        return $result;
    }
}
