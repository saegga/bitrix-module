<?

namespace Sm\Dev\Events;

class Main{

    function defaultEventMethod(){
        // срабатывает только при переходе на страницу модуля - include.php
        \Bitrix\Main\Diag\Debug::dumpToFile('defaultEventMethod', 'defaultEventMethod', PATH_MODULE_LOG . 'events.txt');
        
        return true;
    }

    function defaultEventMethodRegister(){
        
        \Bitrix\Main\Diag\Debug::dumpToFile('defaultEventMethodRegister', 'defaultEventMethodRegister', PATH_MODULE_LOG . 'events.txt');
        
        return true;
    }
}