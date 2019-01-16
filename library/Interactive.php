<?php

class Interactive
{
    private $is_active = false;
    private $table;

    public function __construct(Table $table)
    {
        $this->table = $table;
    }

    public function command(string $str,string $stone_type = null)
    {
        $str = trim($str);
        $stone_type = trim($stone_type);
        switch ($str) {
            case 'start':
                $this->table->init();
                $this->is_active = true;
                $this->table->showTable(); 
                $this->communication("Для хода укажите номер ячейки и тип ('x' или 'o') ");
                break;
            case 'stop':
                $this->is_active = false;
                print "Игра остановлена".PHP_EOL;
                exit;
                break;
            case 'about':
                print "Создатель: Алексей Анисимов".PHP_EOL;
                print "E-mail: ork.04@yandex.ru".PHP_EOL;
                print '2019 г.'.PHP_EOL;
                exit;
                break;
            
            default:
                
                break;
        }
        if($this->is_active == false){ 
            echo "Игра не активна".PHP_EOL; 
            die(); 
        }
        $this->makeStep($str,$stone_type);
    }

    private function makeStep($str,$stone_type)
    {
        if ($stone_type != null && $this->is_active == true) {
            if ($stone_type == 'x') {
                $stone = new Tik('x');
            } elseif ($stone_type == 'o') {
                $stone = new Tok('o');
            } else {
                $this->communication("Тип указан неверно. Попробуйте еще раз.");
            }
            $cell = (integer)$str;
            if ($cell >= 1 && $cell <= 9) {
                if ($this->table->setMove($cell,$stone)){
                    $game_win_response = "Ура! Победили $stone->type-тики.".PHP_EOL;
                    $game_win_response .= " Для того чтобы начать заного, нажмите start, закончить игру -- stop ";
                } else {
                    $game_win_response = "Для хода укажите номер ячейки и тип ('x' или 'o') ";
                }
                $this->table->showTable();
                $this->communication($game_win_response);
            } else {
                $this->communication("Ячейка указана неверно. Попробуйте еще раз.");
            }
        } else {
            $this->communication("Нет такой команды. Проверьте команду и попробуйте еще раз.");
        }
    }

    private function communication($message)
    {
        $var = explode(' ',readline($message.PHP_EOL));
        $str = trim($var[0]);
        $stone_type = (isset($var[1])) ? trim($var[1]) : null;
        $this->command($str,$stone_type);
    }
}