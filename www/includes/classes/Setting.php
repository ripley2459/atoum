<?php

class Setting implements IData
{
    private int $_id;
    private string $_name;
    private string $_value;

    /**
     * @param string $name
     */
    public function __construct(string $name)
    {
        global $DDB;
        $s = 'SELECT * FROM ' . PREFIX . 'settings WHERE name = :name LIMIT 1';
        $r = $DDB->prepare($s);
        if ($r->execute([':name' => $name])) {
            $data = $r->fetch();
            $this->_id = $data['id'];
            $this->_name = $data['name'];
            $this->_value = $data['value'];
        } else {
            Logger::logError('Impossible de récupérer l\'instance du paramètre avec l\'id ' . $this->_id);
        }
    }


    public static function value(string $name): string
    {
        $s = new Setting($name);
        return $s->getValue();
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->_value;
    }

    /**
     * @param string $value
     */
    public function setValue(string $value): void
    {
        $this->_value = $value;
        $this->save();
    }

    /**
     * @inheritDoc
     */
    public function save(): bool
    {
        global $DDB;
        $s = 'UPDATE ' . PREFIX . 'settings SET name = :name, value = :value WHERE id = :id';
        $r = $DDB->prepare($s);
        if ($r->execute([':id' => $this->_id, ':name' => $this->_name, 'value' => $this->value])) {
            Logger::logInfo('Le paramètre avec l\'id ' . $this->_id . ' a été sauvegardé');
        } else {
            Logger::logInfo('impossible de sauvegarder le paramètre avec l\'id ' . $this->_id);
        }
        $r->closeCursor();
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->_name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->_name = $name;
    }

    /**
     * @inheritDoc
     */
    public function register(): bool
    {
        global $DDB;
        $s = 'INSERT INTO ' . PREFIX . 'settings SET name = :name, value = :value';
        $r = $DDB->prepare($s);
        if ($r->execute([':name' => $this->_name, 'value' => $this->_value])) {
            Logger::logInfo('Nouveau paramètre créé avec l\'id ' . $DDB->lastInsertId());
        } else {
            Logger::logError('Impossible de créer ce nouveau paramètre: ' . $this->_name);
        }
        $r->closeCursor();
    }

    /**
     * @inheritDoc
     */
    public function unregister(): bool
    {
        global $DDB;
        $s = 'DELETE FROM ' . PREFIX . 'settings WHERE id = :id';
        $r = $DDB->prepare($s);
        if ($r->execute([':id' => $this->_id])) {
            Logger::logInfo('Ce paramètre ' . $this->_name . ' a été supprimé');
        }
        $r->closeCursor();
    }

    /**
     * @inheritDoc
     */
    public static function checkTable(): bool
    {
        // TODO: Implement checkTable() method.
    }
}