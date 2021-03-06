<?php
namespace Api\V1\Rest\UserImage;

use Api\V1\Rest\Image\ImageEntity;
use Asset\AssetNotApprovedException;
use Asset\Service\ImageServiceInterface;
use Asset\Service\UserImageServiceInterface;
use User\UserInterface;
use ZF\ApiProblem\ApiProblem;
use ZF\Rest\AbstractResourceListener;

/**
 * Class UserImageResource
 */
class UserImageResource extends AbstractResourceListener
{
    /**
     * @var ImageServiceInterface
     */
    protected $imageService;

    /**
     * @var UserImageServiceInterface
     */
    protected $userImageService;

    /**
     * UserImageResource constructor.
     * @param ImageServiceInterface $service
     * @param UserImageServiceInterface $userImageService
     */
    public function __construct(ImageServiceInterface $service, UserImageServiceInterface $userImageService)
    {
        $this->imageService     = $service;
        $this->userImageService = $userImageService;
    }
    
    /**
     * Create a resource
     *
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function create($data)
    {
        $data = (array) $data;
        /** @var UserInterface $user */
        $user = $this->getEvent()->getRouteParam('user');

        $image = new ImageEntity();
        $image->setUrl($data['url']);
        $image->setImageId($data['image_id']);

        $this->imageService->saveNewImage($image);
        $this->userImageService->saveImageToUser($image, $user);

        return $image;
    }

    /**
     * Fetch a resource
     *
     * @param  mixed $userId
     * @return ApiProblem|mixed
     */
    public function fetch($userId)
    {
        try {
            $image = $this->userImageService->fetchImageForUser($userId);
            if ($image === false) {
                return new ApiProblem(404, 'Not Found');
            }
        } catch (AssetNotApprovedException $notApproved) {
            return new ApiProblem(404, 'Not Found');
        }

        return new ImageEntity($image->getArrayCopy());
    }
}
