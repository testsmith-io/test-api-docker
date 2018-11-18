<?php declare(strict_types=1);

namespace TestApi\Domain\Category\Commands\Handlers;

use TestApi\Domain\Category\Commands\AddCategoryCommand;
use TestApi\Domain\Category\Commands\UpdateCategoryCommand;
use TestApi\Domain\Category\Entity\Mapper\CategoryMapper;
use TestApi\Domain\Category\Repository\CategoryRepository;
use TestApi\Domain\Category\Validator\CategoryValidator;
use TestApi\Entity\EntityInterface;

class CategoryHandler
{
    /**
     * @var \TestApi\Domain\Category\Entity\Mapper\CategoryMapper
     */
    private $categoryMapper;

    /**
     * @var \TestApi\Domain\Category\Repository\CategoryRepository
     */
    private $categoryRepository;

    /**
     * @var \TestApi\Domain\Category\Validator\CategoryValidator
     */
    private $validator;

    /**
     * @param \TestApi\Domain\Category\Entity\Mapper\CategoryMapper  $mapper
     * @param \TestApi\Domain\Category\Repository\CategoryRepository $repository
     * @param \TestApi\Domain\Category\Validator\CategoryValidator   $validator
     */
    public function __construct(CategoryMapper $mapper, CategoryRepository $repository, CategoryValidator $validator)
    {
        $this->categoryMapper     = $mapper;
        $this->categoryRepository = $repository;
        $this->validator       = $validator;
    }

    /**
     * @param \TestApi\Domain\Category\Commands\AddCategoryCommand $command
     *
     * @return \TestApi\Entity\EntityInterface
     * @throws \TestApi\Exceptions\Validation\ValidationException
     */
    public function handleAddCategory(AddCategoryCommand $command): EntityInterface
    {
        $this->validator->validate($command->getAttributes());
        $this->categoryRepository->add($this->categoryMapper->map($command->getAttributes()));

        $categoryId = $this->categoryRepository->lastInsertedId();
        $category   = $this->categoryRepository->get($categoryId);

        return $category;
    }

    /**
     * @param \TestApi\Domain\Category\Commands\UpdateCategoryCommand $command
     *
     * @return \TestApi\Entity\EntityInterface
     * @throws \TestApi\Exceptions\Validation\ValidationException
     */
    public function handleUpdateCategory(UpdateCategoryCommand $command): EntityInterface
    {
        $attributes = array_merge(['category_id' => $command->getCategoryId()], $command->getAttributes());
        $this->validator->validate($attributes);

        return $this->categoryRepository->update(
            $command->getCategoryId(),
            $this->categoryMapper->map($command->getAttributes())
        );
    }
}
