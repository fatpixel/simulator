<?php
namespace SimpleZoo\Controllers;

use League\Plates\Engine;
use Okneloper\Session\Session;
use SimpleZoo\Models\AnimalFactory;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\RedirectResponse;

/**
 * Class ZooController
 * @package SimpleZoo\Controllers
 */
class ZooController extends BaseController
{

    /**
     * ZooController constructor.
     * @param \League\Plates\Engine $templates
     * @param \Okneloper\Session\Session $session
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @param \Psr\Http\Message\ResponseInterface $response
     */
    public function __construct(Engine $templates, Session $session, ServerRequestInterface $request, ResponseInterface $response)
    {
        parent::__construct($templates, $session, $request, $response);

        $this->initializeSession();
    }

    /**
     * Initializes the Zoo.
     *
     * @param bool $force
     */
    private function initializeSession($force = false)
    {

        if ($this->session->initialized !== true || $force) {

            $animals = [];

            $animals['Elephant'] = $this->generateAnimals('Elephant', 5);
            $animals['Giraffe'] = $this->generateAnimals('Giraffe', 5);
            $animals['Monkey'] = $this->generateAnimals('Monkey', 5);

            $this->session->animals = $animals;

            $this->session->hours = 0;
            $this->session->initialized = true;
        }

    }

    /**
     * @param $genotype
     * @param int $amount
     *
     * @return array
     */
    private function generateAnimals($genotype, $amount = 5)
    {
        $animals = [];

        for ($i = 1; $i <= $amount; $i++) {

            $animal = AnimalFactory::factory($genotype);

            $animals[] = $animal;
        }

        return $animals;
    }

    /**
     * @return \Psr\Http\Message\ResponseInterface
     */
    private function writeContent($data = [])
    {
        $content = $this->templates->render('zoo', $data);

        $this->response->getBody()->write($content);

        return $this->response;
    }

    /**
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function home()
    {
        $data = [
          'animals' => $this->session->animals,
          'hours' => $this->session->hours,
        ];

        return $this->writeContent($data);
    }

    /**
     * Simulates an hour of time passing by generating a random value between 0 and 20 for each animal
     * before decreasing it's health by that percentage of their current health, respectively.
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function advance()
    {
        $this->session->hours = $this->session->hours + 1;

        $updatedAnimals = $this->session->animals;

        foreach ($updatedAnimals as $genotype => $individuals) {
            foreach ($individuals as $index => $animal) {

                $amount = mt_rand(0, 20) / 100.0;

                if ($animal->isAlive()) {
                    $animal->decreaseHealth($amount);
                }
            }
        }

        $this->session->animals = $updatedAnimals;

        return $this->redirectToHome();
    }

    /**
     * Generates a random value between 10 and 25 for each type of animal and increases the health
     * of each individual by that percentage of their current health, respectively.
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function feed()
    {

        $updatedAnimals = $this->session->animals;

        foreach ($updatedAnimals as $genotype => $individuals) {

            $amount = mt_rand(10, 25) / 100.0;

            foreach ($individuals as $index => $animal) {

                if ($animal->isAlive()) {
                    $animal->increaseHealth($amount);
                }
            }
        }

        $this->session->animals = $updatedAnimals;

        return $this->redirectToHome();
    }

    /**
     * Resets the zoo by clearing the session.
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function reset()
    {
        $this->session->clear();

        return $this->redirectToHome();
    }

    /**
     * @return \Zend\Diactoros\Response\RedirectResponse
     */
    protected function redirectToHome()
    {
        return new RedirectResponse('/');
    }

}
