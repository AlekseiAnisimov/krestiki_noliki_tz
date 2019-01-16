<?php

// Класс реализует игровую доску и взаимодействие с ней

class Table extends JsonRepository
{
    private $field = [[null,null,null,],[null,null,null],[null,null,null]];
    private $is_winner;
    private $steps = 0;

    public function getField()
    {
        return $this->field;
    }

    public function setMove($position,Stone $stone)
    {
        if ($this->is_winner) return true;
        $this->field = $this->read();
        $type = $stone->type;
// пользователь передает номер ячейки. по этому номеру указываются индексы в массиве
        switch ($position) {
            case '1':
                if ($this->field[0][0] == null) {
                    $this->field[0][0] = $type;
                }
                break;
            case '2':
                if ($this->field[0][1] == null) {
                    $this->field[0][1] = $type;
                }
            break;
            case '3':
                if ($this->field[0][2] == null) {
                    $this->field[0][2] = $type;
                }
                break;
            case '4':
                if ($this->field[1][0] == null) {
                    $this->field[1][0] = $type;
                }
                break;
            case '5':
                if ($this->field[1][1] == null) {
                    $this->field[1][1] = $type;
                }
                break;
            case '6':
                if ($this->field[1][2] == null) {
                    $this->field[1][2] = $type;
                }
                break;
            case '7':
                if ($this->field[2][0] == null) {
                    $this->field[2][0] = $type;
                }
                break;
            case '8':
                if ($this->field[2][1] == null) {
                    $this->field[2][1] = $type;
                }
                break;
            case '9':
                if ($this->field[2][2] == null) {
                    $this->field[2][2] = $type;
                }
                break;
            default:
                return false;
                break;
        }
        $this->write($this->field);
        if ($this->win($position)) {
            $this->is_winner = true;
            return true;
        }
// подсчет и ответ , если все ячейки заняты, а победителя нет
        $this->steps++;
        if ($this->steps == 9) {
            $this->showTable();
            print "Больше нет свободных ячеек. Новая игра".PHP_EOL;
            $this->init();
        }
        return false;
    }

// рисует таблицу и отображает ее  пользователю
    public function showTable()
    {
        $field = $this->read();
        echo '___ ___ ___'.PHP_EOL;
        for ($row = 2; $row>=0; $row--) {
            for ($col = 0; $col<=2; $col++) {
                if ($field[$row][$col] == null) {
                    echo ' '.$this->getFieldNumber($row,$col).' |';
                } else {
                    echo ' '.$field[$row][$col].' |';
                }
            }
            echo PHP_EOL;
        }
    }

// получение номера ячейки из индексов массива
    private function getFieldNumber($row, $col)
    {
        $row++;
        $col++;
        $pred = 0;
        if ($row == 2) {
            if ($col == 1) { 
                $pred = 2;
            } elseif ($col == 2) {
                $pred = 1;
            }
        } elseif ($row == 3) {
            if ($col == 1) { 
                $pred = 4;
            } elseif ($col == 2) {
                $pred = 2;
            }
        }
        $number = $row * $col + $pred;
        
        return $number;
    }

// получение индексов массива из числа
    private function getRowCol($field_number)
    {
        $row = 0;
        $col = 0;
        if ($field_number == 9) {
            $row = 2;
            $col = 2;
        } elseif ($field_number == 8) {
            $row = 2;
            $col = 1; 
        } elseif ($field_number == 7) {
            $row = 2;
            $col = 0;
        } elseif ($field_number == 6) {
            $row = 1;
            $col = 2;
        } elseif ($field_number == 5) {
            $row = 1;
            $col = 1;
        } elseif ($field_number == 4) {
            $row = 1;
            $col = 0;
        } elseif ($field_number == 3) {
            $row = 0;
            $col = 2;
        } elseif ($field_number == 2) {
            $row = 0;
            $col = 1;
        } elseif ($field_number == 1) {
            $row = 0;
            $col = 0;
        }
        return [$row,$col];
    }

// поиск на игровом поле победителя
// происходит обработка по горизотали, вертикали и по диагоналям 
    private function win($position) 
    {  
        $mass = $this->getRowCol($position);
        $type = $this->field[$mass[0]][$mass[1]];
        $horizontally = 0;
        $vertically = 0;
        $diagonally_up = 0;
        $diagonally_down = 0;
        for ($i = 0; $i<=2; $i++) {
            if ($this->field[$mass[0]][$i] != $type) break;
            $horizontally++;
        }
        for ($i = 0; $i<=2; $i++) {
            if ($this->field[$i][$mass[1]] != $type) break;
            $vertically++;
        }
        if (in_array($position,[1,9,5])) {            
            for ($i = 0; $i<=2; $i++) {
                if ($this->field[$i][$i] != $type) break;
                $diagonally_up++;
            }
        }       
        if (in_array($position,[3,7,5])) {            
            $j = 0;
            for ($i = 2; $i>=0; $i--) {
                if ($this->field[$i][$j] != $type) break;
                $diagonally_down++;
                $j++;
            }
        }
        if ($horizontally == 3 || $vertically == 3|| $diagonally_up == 3 || $diagonally_down ==3) {
            return true;
        }
        return false;
    }

}