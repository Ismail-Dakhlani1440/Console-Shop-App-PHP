<?php

interface Repository{
    public function fetchAll();
    public function insertObject($obj);
}