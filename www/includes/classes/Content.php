<?php

abstract class Content implements IData, IStatuable
{
    protected int $_id;
    protected string $_name;
    protected string $_registration;
    protected int $_views;
    protected int $_type;
    protected int $_owner;
    protected int $_parent;
    protected int $_status;
    protected string $_content;

    /**
     * @return Content
     */
    public static abstract function getInstance(): Content;

    /**
     * Donne le type de donnée.
     * @return mixed
     */
    public static abstract function getType(): int;

    /**
     * @inheritDoc
     */
    public function register(): void
    {
        global $DDB;
        $s = 'INSERT INTO ' . PREFIX . 'contents SET name = :name, views = :views, type = :type, owner = :owner, parent = :parent, status = :status, content = :content';
        $r = $DDB->prepare($s);
        if ($r->execute([':name' => $this->_name, 'views' => $this->_views, ':type' => $this->_type, ':owner' => $this->_owner, ':parent' => $this->_parent, ':status' => $this->_status, ':content' => $this->_content])) {
            $this->__construct($DDB->lastInsertId());
            Logger::logInfo('Nouvelle instance de type ' . $this->_type . ' crée avec l\'id ' . $this->_id);
        } else {
            Logger::logError('Impossible de créer une nouvelle instance de type ' . $this->_type);
        }
        $r->closeCursor();
    }

    /**
     * @param int $id
     */
    public function __construct(int $id = -1)
    {
        if ($id == -1) return;
        global $DDB;
        $s = 'SELECT * FROM ' . PREFIX . 'contents WHERE id = :id LIMIT 1';
        $r = $DDB->prepare($s);
        if ($r->execute([':id' => $id])) {
            $data = $r->fetch();
            $this->_id = $data['id'];
            $this->_name = $data['name'];
            $this->_registration = $data['registration'];
            $this->_views = $data['views'];
            $this->_type = $data['type'];
            $this->_owner = $data['owner'];
            $this->_parent = $data['parent'];
            $this->_status = $data['status'];
            $this->_content = $data['content'];
        } else {
            Logger::logError('Impossible de récupérer l\'instance de type ' . $this->_type . ' avec l\'id ' . $this->_id);
        }
        $r->closeCursor();
    }

    /**
     * @inheritDoc
     */
    public function unregister(): void
    {
        global $DDB;
        $s = 'DELETE FROM ' . PREFIX . 'contents WHERE id = :id';
        $r = $DDB->prepare($s);
        if ($r->execute([':id' => $this->_id])) {
            Logger::logInfo($this->_name . ' a été supprimé');
        }
        $r->closeCursor();
    }

    /**
     * @inheritDoc
     */
    public function save(): void
    {
        global $DDB;
        $s = 'UPDATE ' . PREFIX . 'contents SET name = :name, views = :views, type = :type, owner = :owner, parent = :parent, status = :status, content = :content WHERE id = :id';
        $r = $DDB->prepare($s);
        if ($r->execute([':id' => $this->_id, ':name' => $this->_name, 'views' => $this->_views, ':type' => $this->_type, ':owner' => $this->_owner, ':parent' => $this->_parent, ':status' => $this->_status, ':content' => $this->_content])) {
            $this->__construct($this->_id);
            Logger::logInfo('L\'instance de type ' . $this->_type . ' avec l\'id ' . $this->_id . ' a été sauvegardée');
        } else {
            Logger::logInfo('impossible de sauvegarder l\'instance de type ' . $this->_type . ' avec l\'id ' . $this->_id);
        }
        $r->closeCursor();
    }
}