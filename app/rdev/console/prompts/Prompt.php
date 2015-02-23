<?php
/**
 * Copyright (C) 2015 David Young
 * 
 * Defines a console prompt
 */
namespace RDev\Console\Prompts;
use RDev\Console\Responses;
use RDev\Console\Responses\Formatters;

class Prompt
{
    /** @var Formatters\Padding The space padding formatter to use */
    private $paddingFormatter  = null;
    /** @var resource The input stream to look for answers in */
    private $inputStream = null;

    /***
     * @param Formatters\Padding $paddingFormatter The space padding formatter to use
     * @param resource|null $inputStream The input stream to look for answers in
     */
    public function __construct(Formatters\Padding $paddingFormatter, $inputStream = null)
    {
        $this->paddingFormatter = $paddingFormatter;

        if($inputStream === null)
        {
            $inputStream = STDIN;
        }

        $this->setInputStream($inputStream);
    }

    /**
     * Prompts the user to answer a question
     *
     * @param Questions\IQuestion $question The question to ask
     * @param Responses\IResponse $response The response to write output to
     * @return mixed The user's answer to the question
     * @throws \RuntimeException Thrown if we failed to get the user's answer
     */
    public function ask(Questions\IQuestion $question, Responses\IResponse $response)
    {
        $response->write("<question>{$question->getText()}</question>");

        if($question instanceof Questions\MultipleChoice)
        {
            /** @var Questions\MultipleChoice $question */
            $response->writeln("");
            $choicesAreAssociative = $question->choicesAreAssociative();
            $choiceTexts = [];

            foreach($question->getChoices() as $key => $choice)
            {
                if(!$choicesAreAssociative)
                {
                    // Make the choice 1-indexed
                    $key += 1;
                }

                $choiceTexts[] = [$key . ")", $choice];
            }

            $response->writeln($this->paddingFormatter->format($choiceTexts, function($line)
            {
                return "  {$line[0]} {$line[1]}";
            }));
            $response->write($question->getAnswerLineString());
        }

        $answer = fgets($this->inputStream, 4096);

        if($answer === false)
        {
            throw new \RuntimeException("Failed to get answer");
        }

        $answer = trim($answer);

        if(mb_strlen($answer) == 0)
        {
            $answer = $question->getDefaultAnswer();
        }

        return $question->formatAnswer($answer);
    }

    /**
     * Sets the input stream
     *
     * @param resource $inputStream The input stream to look for answers in
     * @throws \InvalidArgumentException Thrown if the input stream is not a resource
     */
    public function setInputStream($inputStream)
    {
        if(!is_resource($inputStream))
        {
            throw new \InvalidArgumentException("Input stream must be resource");
        }

        $this->inputStream = $inputStream;
    }
}