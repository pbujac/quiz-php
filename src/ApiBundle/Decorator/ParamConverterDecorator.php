<?php

namespace ApiBundle\Decorator;

use ApiBundle\Transformer\TransformerInterface;
use Doctrine\Common\Persistence\ObjectManager;
use FOS\RestBundle\Request\RequestBodyParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ParamConverterDecorator implements ParamConverterInterface
{
    /**
     * @var RequestBodyParamConverter
     */
    private $paramConverter;

    /**
     * @var ObjectManager
     */
    private $em;

    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @param RequestBodyParamConverter $paramConverter
     * @param ObjectManager $em
     * @param ContainerInterface $container
     */
    public function __construct(RequestBodyParamConverter $paramConverter, ObjectManager $em, ContainerInterface $container)
    {
        $this->paramConverter = $paramConverter;
        $this->container = $container;
        $this->em = $em;
    }

    /**
     * @param Request $request
     * @param ParamConverter $configuration
     *
     * @return bool
     */
    public function apply(Request $request, ParamConverter $configuration)
    {
        if (isset($configuration->getOptions()['transformer'])) {

            if (isset($configuration->getOptions()['search_criteria'])) {
                $searchCriteria = (array)$configuration->getOptions()['search_criteria'];
            } else {
                $searchCriteria = ['id' => 'id'];
            }

            $options = $configuration->getOptions();

            /** @var TransformerInterface $transformer */
            $transformer = $this->container->get($options['transformer']);

            $computedCriteria = $this->getComputedCriteria($request, $searchCriteria);
            $entity = $this->em->getRepository($transformer->getEntityClass())
                ->findOneBy($computedCriteria);

            if (!$entity) {
                throw new NotFoundHttpException('Entity not found.');
            }

            $dto = $transformer->transform($entity);

            $options['deserializationContext']['target'] = $dto;

            $configuration->setOptions($options);
        }

        return $this->paramConverter->apply($request, $configuration);
    }

    /**
     * @param ParamConverter $configuration
     *
     * @return bool
     */
    public function supports(ParamConverter $configuration)
    {
        if (isset($configuration->getOptions()['transformer'])) {
            $transformer = $this->container->get($configuration->getOptions()['transformer']);
            if (!$transformer instanceof TransformerInterface) {
                return false;
            }
        }

        return $this->paramConverter->supports($configuration);
    }

    /**
     * @param Request $request
     * @param array $searchCriteria
     *
     * @return array
     */
    private function getComputedCriteria(Request $request, array $searchCriteria)
    {
        $computedCriteria = [];
        foreach ($searchCriteria as $parameter => $property) {
            if (!$request->get($parameter)) {
                throw new \LogicException(
                    sprintf('This converter requires "%s" route parameter.', $parameter)
                );
            }

            $computedCriteria[$property] = $request->get($parameter);
        }

        return $computedCriteria;
    }

}
