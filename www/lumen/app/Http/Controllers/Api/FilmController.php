<?php declare(strict_types=1);

namespace TestApi\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Pagination\LengthAwarePaginator;
use TestApi\Command\Bus\CommandBus;
use TestApi\Domain\Film\Commands\AddFilmCommand;
use TestApi\Domain\Film\Commands\UpdateFilmCommand;
use TestApi\Domain\Film\Repository\FilmRepository;
use TestApi\Transformer\FilmTransformer;
use TestApi\Transformer\Transformer;

class FilmController extends AbstractController
{
    /**
     * @var \TestApi\Domain\Film\Repository\FilmRepository
     */
    private $repository;

    /**
     * @param \TestApi\Domain\Film\Repository\FilmRepository $repository
     * @param \TestApi\Transformer\Transformer               $transformer
     */
    public function __construct(FilmRepository $repository, Transformer $transformer)
    {
        $this->repository = $repository;

        parent::__construct($transformer);
    }

    /**
     * @param int $filmId
     *
     * @return \Illuminate\Http\Response
     */
    public function show(int $filmId): Response
    {
        $film = $this->repository->get($filmId);

        return $this->response($this->item($film, FilmTransformer::class));
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request): Response
    {
        $page     = (int)$request->query('page', 1);
        $pageSize = (int)$request->query('page_size', 15);
        $items    = $this->repository->all($page, $pageSize);
        $total    = $this->repository->count();
        $films    = new LengthAwarePaginator($items, $total, $pageSize, $page);

        return $this->response($this->collection($films, FilmTransformer::class));
    }

    /**
     * @param \Illuminate\Http\Request       $request
     * @param \TestApi\Command\Bus\CommandBus $commandBus
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, CommandBus $commandBus): Response
    {
        $film = $commandBus->execute(new AddFilmCommand($request->post()));

        return $this->response($this->item($film, FilmTransformer::class), Response::HTTP_CREATED);
    }

    /**
     * @param int                            $filmId
     * @param \Illuminate\Http\Request       $request
     *
     * @param \TestApi\Command\Bus\CommandBus $commandBus
     *
     * @return \Illuminate\Http\Response
     */
    public function update(int $filmId, Request $request, CommandBus $commandBus): Response
    {
        $film = $commandBus->execute(new UpdateFilmCommand($filmId, $request->post()));

        return $this->response($this->item($film, FilmTransformer::class));
    }

    /**
     * @param int $filmId
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $filmId): Response
    {
        $this->repository->remove($filmId);

        return $this->response();
    }
}
