<?php

interface RuleIface
{
    public function validate(string $input): bool;
    public function getRuleText(): string;
}

class FizzRule implements RuleIface
{
    public function validate(string $input): bool
    {
        return $input % 3 === 0;
    }

    public function getRuleText(): string
    {
        return 'Fizz';
    }
}

class BuzzRule implements RuleIface
{
    public function validate(string $input): bool
    {
        return $input % 5 === 0;
    }

    public function getRuleText(): string
    {
        return 'Buzz';
    }
}

interface RuleBucketIface
{
    public function appendRule(RuleIface $rule): void;
}

class Item implements RuleBucketIface
{
    private $rules;

    public function __construct()
    {
        $this->rules = [];
    }

    public function appendRule(RuleIface $rule): void
    {
        $this->rules[] = $rule;
    }

    public function render(string $input): string
    {
        $out = null;
        /** @var  RuleIface $rule */
        foreach ($this->rules as $rule) {
            if($rule->validate($input)) {
                $out.= $rule->getRuleText();
            }
        }

        return is_null($out) ? $input : $out;
    }
}

$item = new Item();
$item->appendRule(new FizzRule());
$item->appendRule(new BuzzRule());

echo $item->render("1"); // 1
echo $item->render("2"); // 2
echo $item->render("3"); // Fizz
echo $item->render("4"); // 4
echo $item->render("5"); // Buzz
echo $item->render("6"); // Fizz
echo $item->render("7"); // 7
echo "...";
echo $item->render("15"); // FizzBuzz


