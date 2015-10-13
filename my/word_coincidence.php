<?php
	header('Content-Type: text/html; charset=utf-8');
    setlocale(LC_ALL,'ru_RU.UTF-8');
?>

<html>
<head>
    <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
</head>
<body>
	<form method="POST">
		<h3>Enter the text</h3>
		<textarea name="text" cols="50" rows="5">
			<?= !empty($_REQUEST['text']) ? $_REQUEST['text'] :
				"Мой замок был ограблен\nНа меня напал высокоуровневый замок\nОграблен замок моего товарища";
			?>
		</textarea> <br />
		<input type="submit" name="get_statistic" value="Get statistic" />
	</form>
</body>
</html>

<?php

//Расширяемый класс для сбора статистики строк в стиле "over engineering"

class Text
{
	protected $_lineCollection = [];
	protected $_coincidence    = [];
	
	public function __construct($text)
	{
		if (!is_string($text))
			throw new Exception('String expected in Text construct');
		
		foreach (explode("\n", $text) as $kay => $value)
			$this->_lineCollection[] = new Line($value);
	}
	
	//Начинаем сбор статистики
	//Методы статистики разделены для дальнейшего отдельного использования в клиентском приложении
	//К примеру, если нужно добавить строки из другого источника. Стартуем статистику -> добавляем строки -> получаем статистику
	public function startStatistic()
	{
		foreach ($this->_lineCollection as $line)
			$this->coincidenceRecord($line);
		return $this;
	}
    
    public function getLines()
    {
        return $this->_lineCollection;
    }
	
	//Записываем совпадения. Используем ключ массива, как слово
	//Метод так же может быть использован в клиентском коде
	public function coincidenceRecord(Line $line)
	{
		foreach ($line->getWords() as $word) {
			if (empty($this->_coincidence[$word]))
				$this->_coincidence[$word] = 0;
			$this->_coincidence[$word] ++;
		}
		return $this;
	}
	
	//Возвращаем результаты статистики
	public function getStatistic()
	{
		if (!$this->_coincidence)
			$this->startStatistic();
		return $this->_coincidence;
	}
	
	//Быстрый старт для цепочки выражений. Рендерит статистику.
	public static function quickStatistic($text)
	{
        $view = new StatisticView($text = new Text($text));
		echo $view->getStatisticView();
		return $text;
	}
}

class StatisticView
{
    protected $_text;
    
    public function __construct($text)
    {
        $this->_text = $text;
    }
    
    //Представление статистики. В идеале - использовать отдельный класс и шаблон
	public function getStatisticView()
	{
	    $statistic = $this->_text->getStatistic();
		
		//Алгоритм анализа массива слов
		//В идеале выносится в отдельный метод, формирующий массив или объект-стратегию для логики отбора статистики)
		$result = '<br />Word statistic:<hr />1)<br />';
		asort($statistic, SORT_NUMERIC);
		$statistic = array_reverse($statistic, true);
        var_dump($statistic);
		foreach ($statistic as $word => $count) {
            if ($count <= 1) break;
            $result = $result . "\"" . $word . "\" | Совпадений: " . ($count) . " <br />";
            $wordsForFind .= $word . ' ';
		}
        
        $result2 = '<hr />2)<br />' . $wordsForFind . " | Совпадений: ";
        $countLines = 0;
        foreach ($this->_text->getLines() as $line) {
            if ($line->findWords($wordsForFind)) 
                $countLines++;
        }
        
		return $result . $result2 . $countLines;
	}
}

class Line
{
	protected $_value;
	protected $_words;
	
	public function __construct($value)
	{
		if (!is_string($value))
			throw new Exception('String expected in Line construct');
		$this->_value = trim($value);
	}
	
	public function getValue()
	{
		return $this->_value;
	}
	
	public function getWords()
	{
		//Отложенная инициализация, если значение будет браться из внешнего источника.
		if (!$this->_words) {
			$this->_words = explode(" ", $this->_value);
    		//Обработка слов
    		$this->_words = array_map(function($word) {
    			$word = trim($word);
    			$word = preg_replace ("/[^a-zA-ZА-Яа-я0-9]/u", "", $word);
    			$word = mb_strtolower($word, 'UTF-8');
    			return $word;
    		}, $this->_words);
        }
		return $this->_words;
	}
    
    //Полиморфный метод поиска слов в строке
    public function findWords($words)
    {
        if (is_string($words))
            $words = explode(' ', trim($words));
        foreach ($words as $k => $word)
            if (!in_array($word, $this->getWords()))
                return false;
        return true;
    }
}

if (!empty($_REQUEST["get_statistic"]))
	Text::quickStatistic($_REQUEST["text"]);