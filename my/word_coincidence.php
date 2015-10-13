<?php
	/*header('Content-Type: text/html; charset=UTF-8');

	mb_internal_encoding('UTF-8'); 
	mb_http_output('UTF-8'); 
	
	mb_http_input('UTF-8'); 
	mb_regex_encoding('UTF-8');*/
?>

<html>
<head>
	<!--meta charset="UTF-8"-->
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
	
	//Представление статистики. В идеале - использовать отдельный класс и шаблон
	public function getStatisticView()
	{
		if (!$this->_coincidence)
			$this->startStatistic();
			
		/*echo "<br />Общая статистика: <br />";
		var_dump($this->_coincidence);
		echo "<br /><hr />";*/
		
		//Алгоритм анализа массива слов
		//D идеале выносится в отдельный метод, формирующий массив или объект-стратегию для логики отбора статистики)
		$result = '<br />Word statistic:<hr />';
		asort($this->_coincidence, SORT_NUMERIC);
		$this->_coincidence = array_reverse($this->_coincidence, true);
		//Буферизируем слова
		$wordBuffer = [];
		//Запоминаем последнее количество
		$last	    = 0;
		foreach ($this->_coincidence as $word => $count) {
			//echo $word . " " . $count . " <br>";
			if ($last !== $count && $last !== 0) {
				//Закрепляем буфер
				$result = $result . "\"" . implode(" ", $wordBuffer) . "\" | Совпадений: " . ($count + 1) . " <br />";
			}
			if ($count <= 1) break;
			$wordBuffer[] = $word;
			$last = $count;
		}
		return $result;
	}
	
	//Быстрый старт для цепочки выражений. Рендерит статистику.
	public static function quickStatistic($text)
	{
		$text = new Text($text);
		echo $text->getStatisticView();
		return $text;
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
		if (!$this->_words)
			$this->_words = explode(" ", $this->_value);
		//Обработка слов
		$this->_words = array_map(function($word) {
			$word = trim($word);
			$word = preg_replace ("/[^a-zA-ZА-Яа-я0-9\s]/", "", $word);
			$word = mb_strtolower($word);
			return $word;
		}, $this->_words);
		return $this->_words;
	}
}

if (!empty($_REQUEST["get_statistic"]))
	Text::quickStatistic($_REQUEST["text"]);