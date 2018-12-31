<?php

class Item
{
    public function render(string $input): string
    {
        $isFizz = $input % 3 === 0;
        $isBuzz = $input % 5 === 0;

        if ($isFizz && $isBuzz) {
            return 'FizzBuzz';
        } elseif ($isFizz) {
            return 'Fizz';
        } elseif ($isBuzz) {
            return 'Buzz';
        }

        return $input;
    }
}

$item = new Item();

echo $item->render("1"); // 1
echo $item->render("2"); // 2
echo $item->render("3"); // Fizz
echo $item->render("4"); // 4
echo $item->render("5"); // Buzz
echo $item->render("6"); // Fizz
echo $item->render("7"); // 7
echo "...";
echo $item->render("15"); // FizzBuzz
