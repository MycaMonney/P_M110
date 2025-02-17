<?php
namespace Interfaces;

interface IActiveRecord {
    public static function readById($id);
    public function create();
    public function update();
    public function delete();
}