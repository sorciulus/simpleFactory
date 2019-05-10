<?php

namespace SimpleFactory\Tests\Objects;

class Book
{
    /**
     * The title of Book
     *
     * @var string|null
     */
    private $title;

    /**
     * The description of Book
     *
     * @var string|null
     */
    private $description;

    /**
     * The year of Book
     *
     * @var integer|null
     */
    private $year;

    /**
     * The genre of book
     *
     * @var string|null
     */
    private $genre;

    /**
     * The rating of book
     *
     * @var float|null
     */
    private $rating;

    /**
     * The publisher of book
     *
     * @var Publisher
     */
    private $publisher;

    /**
     * @param string|null $title
     * @param string|null $description
     * @param integer|null $year
     * @param string|null $genre
     * @param float|null $rating
     * @param Publisher $publisher
     */
    public function __construct(?string $title, ?string $description, ?int $year, ?string $genre, ?float $rating, Publisher $publisher)
    {
        $this->title = $title;
        $this->description = $description;
        $this->year = $year;
        $this->genre = $genre;
        $this->rating = $rating;
        $this->publisher = $publisher;
    }

    /**
     * Get the title of Book
     *
     * @return  string|null
     */
    public function getTitle() :?string
    {
        return $this->title;
    }

    /**
     * Get the description of Book
     *
     * @return  string|null
     */
    public function getDescription() :?string
    {
        return $this->description;
    }

    /**
     * Get the year of Book
     *
     * @return  integer|null
     */
    public function getYear() :?int
    {
        return $this->year;
    }

    /**
     * Get the genre of book
     *
     * @return  string|null
     */
    public function getGenre() :?string
    {
        return $this->genre;
    }
    
    /**
     * Get the rating of book
     *
     * @return float|null
     */
    public function getRating() :?float
    {
        return $this->rating;
    }

    /**
     * Get the publisher of book
     *
     * @return Publisher
     */
    public function getPublisher() : Publisher
    {
        return $this->publisher;
    }
}
