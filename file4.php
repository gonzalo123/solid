<?php

interface RenderIface
{
    public function render(string $input): string;
}

interface RuleIface
{
    public function validate(string $input): bool;

    public function getRuleText(): string;
}

interface RenderBucketIface
{
    public function appendRuleRenderer(RenderIface $renderer): void;
}

class RuleRender implements RenderIface
{
    private $rule;

    public function __construct(RuleIface $rule)
    {
        $this->rule = $rule;
    }

    public function render(string $input): string
    {
        return $this->rule->validate($input) ? $this->rule->getRuleText() : false;
    }
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

class Item implements RenderIface
{
    private $renderers;

    public function __construct()
    {
        $this->renderers = [];
    }

    public function appendRuleRenderer(RenderIface $renderer): void
    {
        $this->renderers[] = $renderer;
    }

    public function render(string $input): string
    {
        $out = null;
        /** @var  RenderIface $renderer */
        foreach ($this->renderers as $renderer) {
            $ruleOut = $renderer->render($input);
            if ($ruleOut) {
                $out .= $ruleOut;
            }
        }

        return is_null($out) ? $input : $out;
    }
}

class FizzBuilder
{
    public static function factory()
    {
        return new RuleRender(new FizzRule());
    }
}

class BuzzBuilder
{
    public static function factory()
    {
        return new RuleRender(new BuzzRule());
    }
}


$item = new Item();
$item->appendRuleRenderer(FizzBuilder::factory());
$item->appendRuleRenderer(BuzzBuilder::factory());

echo $item->render("1"); // 1
echo $item->render("2"); // 2
echo $item->render("3"); // Fizz
echo $item->render("4"); // 4
echo $item->render("5"); // Buzz
echo $item->render("6"); // Fizz
echo $item->render("7"); // 7
echo "...";
echo $item->render("15"); // FizzBuzz


