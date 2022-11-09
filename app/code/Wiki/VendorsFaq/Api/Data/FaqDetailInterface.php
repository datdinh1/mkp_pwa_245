<?php

namespace Wiki\VendorsFaq\Api\Data;

/**
 * @api
 */
interface FaqDetailInterface
{
    const ID           = 'id';
    const FAQ_ID       = 'faq_id';
    const QUESTION     = 'question';
    const ANSWER       = 'answer';




    /**
     * Get ID
     *
     * @return int|null
     */
    public function getId();

    /**
     * Get Faq ID
     *
     * @return int|null
     */
    public function getFaqId();

    /**
     * Get Question of FAQ
     *
     * @return string
     */
    public function getQuestion();


    /**
     * Get Answer of FAQ
     * 
     * @return string
     */
    public function getAnswer();



    /**
     * Set ID
     *
     * @param int $id
     * @return $this
     */
    public function setId($id);

    /**
     * Set Faq ID
     *
     * @param int $faq
     * @return $this
     */
    public function setFaqId($faq);

    /**
     * Set question
     *
     * @param  string $question
     * @return $this
     */
    public function setQuestion($question);


    /**
     * Set Answer of Faq
     *
     * @param string $answer
     * @return $this
     */
    public function setAnswer($answer);

}
