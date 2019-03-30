<?php
/**
 * Created by PhpStorm.
 * User: Toole
 * Date: 29.03.2019
 * Time: 10:16
 *
 *
 * @param $root_path string
 * @param $array_files array
 * @param $array_all
 * @param $sql object
 */
require_once "SqlCommands.php";

class ScanDir
{
    private $root_path;
    private $array_files;

    /**
     * @return array
     */
    public function scan()
    {
        $sql = new SqlCommands();

        $this->root_path = $_SERVER['DOCUMENT_ROOT'];
        $this->array_files = scandir($this->root_path);
        $array_all = [];

        for ($i = 0; $i < count($this->array_files); $i++) {
            $array_all[$i] = [
                'filename' => pathinfo($this->root_path . "/" . $this->array_files[$i])['filename'],
                'filesize' => ((filetype($this->root_path . "/" . $this->array_files[$i]) == "dir") ? "dir" : filesize($this->root_path . "/" . $this->array_files[$i])),
                'filetype' => (filetype($this->root_path . "/" . $this->array_files[$i]) != "dir") ? pathinfo($this->root_path . "/" . $this->array_files[$i])['extension'] : "",
                'filetime' => date('Y.m.d H:i:s', filemtime($this->root_path . "/" . $this->array_files[$i]))
            ];
        }

        $sql->createCommand(false, $array_all);
        return $sql->createCommand(true);
    }
}