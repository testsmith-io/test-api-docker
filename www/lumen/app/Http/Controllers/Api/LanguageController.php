<?php declare(strict_types=1);

namespace TestApi\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Pagination\LengthAwarePaginator;
use TestApi\Command\Bus\CommandBus;
use TestApi\Domain\Language\Commands\AddLanguageCommand;
use TestApi\Domain\Language\Commands\UpdateLanguageCommand;
use TestApi\Domain\Language\Repository\LanguageRepository;
use TestApi\Transformer\LanguageTransformer;
use TestApi\Transformer\Transformer;

class LanguageController extends AbstractController
{
    /**
     * @var \TestApi\Domain\Language\Repository\LanguageRepository
     */
    private $repository;

    /**
     * @param \TestApi\Domain\Language\Repository\LanguageRepository $repository
     * @param \TestApi\Transformer\Transformer                       $transformer
     */
    public function __construct(LanguageRepository $repository, Transformer $transformer)
    {
        $this->repository = $repository;

        parent::__construct($transformer);
    }

    /**
     * @param int $languageId
     *
     * @return \Illuminate\Http\Response
     */
    public function show(int $languageId): Response
    {
        $language = $this->repository->get($languageId);

        return $this->response($this->item($language, LanguageTransformer::class));
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request): Response
    {
        $page      = (int)$request->query('page', 1);
        $pageSize  = (int)$request->query('page_size', 15);
        $items     = $this->repository->all($page, $pageSize);
        $total     = $this->repository->count();
        $languages = new LengthAwarePaginator($items, $total, $pageSize, $page);

        return $this->response($this->collection($languages, LanguageTransformer::class));
    }

    /**
     * @param \Illuminate\Http\Request       $request
     * @param \TestApi\Command\Bus\CommandBus $commandBus
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, CommandBus $commandBus): Response
    {
        $language = $commandBus->execute(new AddLanguageCommand($request->post()));

        return $this->response($this->item($language, LanguageTransformer::class), Response::HTTP_CREATED);
    }

    /**
     * @param int                            $languageId
     * @param \Illuminate\Http\Request       $request
     *
     * @param \TestApi\Command\Bus\CommandBus $commandBus
     *
     * @return \Illuminate\Http\Response
     */
    public function update(int $languageId, Request $request, CommandBus $commandBus): Response
    {
        $language = $commandBus->execute(new UpdateLanguageCommand($languageId, $request->post()));

        return $this->response($this->item($language, LanguageTransformer::class));
    }

    /**
     * @param int $languageId
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $languageId): Response
    {
        $this->repository->remove($languageId);

        return $this->response();
    }
}
