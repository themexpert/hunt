<?php

namespace Hunt\Http\Controllers\Api;

use Hunt\Comment;
use Hunt\Feature;
use Illuminate\Http\Request;
use Hunt\Events\NewCommentAdded;
use Hunt\Http\Controllers\Controller;
use Hunt\Repositories\CommentsRepository;

class CommentsController extends Controller
{
    /**
     * Instance of suggests repository.
     *
     * @var CommentsRepository
     */
    protected $commentsRepository;

    /**
     * Create a new instance of suggests controller.
     *
     * @param CommentsRepository $commentsRepository
     */
    public function __construct(CommentsRepository $commentsRepository)
    {
        $this->middleware(['auth:api', 'emailActivation']);

        $this->commentsRepository = $commentsRepository;
    }

    /**
     * Add a new comment.
     *
     * @param int     $featureId
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function add($featureId, Request $request)
    {
        $this->validate($request, [
            'message' => 'required'
        ]);

        $comment = $this->commentsRepository->add(
            $featureId,
            $request->input('message')
        );

        event(new NewCommentAdded(Feature::find($featureId), $comment));

        return $this->responseCreated([
            'comment' => $this->commentsRepository->getCommentById($featureId, $comment->id),
            'message' => 'New comment has been added'
        ]);
    }

    /**
     * Get comments related to the given feature.
     *
     * @param int     $featureId
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index($featureId, Request $request)
    {
        return $this->responseJson($this->commentsRepository->get(
            $request->input('limit'),
            $request->input('searchTerms'),
            $featureId
        ));
    }

    /**
     * Remove an exisint comment.
     *
     * @param int $featureId
     * @param int $commentId
     * @return \Illuminate\Http\JsonResponse
     */
    public function remove($featureId, $commentId)
    {
        $this->commentsRepository->remove($featureId, $commentId);

        return $this->responseOk([
           'message' => 'Comment has been deleted'
        ]);
    }

    /**
     * Update an existing feature suggestion.
     *
     * @param int $featureId
     * @param int $commentId
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($featureId, $commentId, Request $request)
    {
        $this->validate($request, [
            'message' => 'required'
        ]);

        $this->commentsRepository->update(
            $featureId,
            $commentId,
            $request->input('message')
        );

        return $this->responseOk([
            'comment_updated' => true,
            'message' => 'Comment has been updated'
        ]);
    }

    /**
     * Get a comment by the given feature and comment id.
     *
     * @param int $featureId
     * @param int $commentId
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($featureId, $commentId)
    {
        return $this->responseOk([
            'comment' => $this->commentsRepository->getCommentById($featureId, $commentId)
        ]);
    }
}