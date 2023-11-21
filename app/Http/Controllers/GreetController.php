<?php
namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

/**
 * @OA\Info(
 *     description="Contoh API doc menggunakan OpenAPI/Swagger",
 *     version="0.0.1",
 *     title="Contoh API documentation",
 *     termsOfService="http://swagger.io/terms/",
 *     @OA\Contact(
 *         email="choirudin.emchagmail.com"
 *     ),
 *     @OA\License(
 *         name="Apache 2.0",
 *         url="http://www.apache.org/licenses/LICENSE-2.0.html"
 *     )
 * )
 */

class GreetController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/greet",
     *     tags={"greeting"},
     *     summary="Returns a Sample API response",
     *     description="A sample greeting to test out the API",
     *     operationId="greet",
     *     @OA\Parameter(
     *         name="firstname",
     *         description="nama depan",
     *         required=true,
     *         in="query",
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="lastname",
     *         description="nama belakang",
     *         required=true,
     *         in="query",
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Response(
     *         response="default",
     *         description="successful operation"
     *     )
     * )
     */
    public function greet(Request $request)
    {
        $userData = $request->only([
            'firstname',
            'lastname',
        ]);

        if (empty($userData['firstname']) && empty($userData['lastname'])) {
            return new \Exception('Missing data', 404);
        }

        return 'Halo ' . $userData['firstname'] . ' ' . $userData['lastname'];
    }

/**
 * @OA\Get(
 *     path="/api/gallery",
 *     tags={"gallery"},
 *     summary="Returns a list of gallery items",
 *     description="Get a list of gallery items with images",
 *     operationId="getGallery",
 *     @OA\Parameter(
 *         name="category",
 *         in="query",
 *         description="Filter by category",
 *         @OA\Schema(type="string")
 *     ),
 *     @OA\Parameter(
 *         name="limit",
 *         in="query",
 *         description="Limit the number of results",
 *         @OA\Schema(type="integer", format="int32")
 *     ),
 *     @OA\Response(
 *         response="default",
 *         description="successful operation",
 *         @OA\JsonContent(
 *             type="array",
 *             @OA\Items(
 *                 type="object",
 *                 @OA\Property(property="id", type="integer"),
 *                 @OA\Property(property="title", type="string"),
 *                 @OA\Property(property="picture", type="string"),
 *                 @OA\Property(property="created_at", type="string"),
 *                 @OA\Property(property="updated_at", type="string"),
 *             )
 *         )
 *     )
 * )
 */
public function getGallery(Request $request)
{
    $data = Post::all();
        $picture = [];
        foreach ($data as $item) {
            $detail = [
                'id' => $item->id,
                'title' => $item->title,
                'description' => $item->description,
                'picture' => $item->picture,
                'created_at' => $item->created_at,
                'updated_at' => $item->updated_at
            ];
            array_push($picture, $detail);
        }

        return response()->json($picture);
}

/**
 * @OA\Post(
 *     path="/api/gallery",
 *     tags={"gallery"},
 *     summary="Store a new post with an image",
 *     description="Store a new post with an image in the gallery",
 *     operationId="storeGallery",
 *     @OA\RequestBody(
 *         required=true,
 *         description="Post data with an image",
 *         @OA\MediaType(
 *             mediaType="multipart/form-data",
 *             @OA\Schema(
 *                 @OA\Property(
 *                     property="title",
 *                     type="string",
 *                     description="Title of the post"
 *                 ),
 *                 @OA\Property(
 *                     property="description",
 *                     type="string",
 *                     description="Description of the post"
 *                 ),
 *                 @OA\Property(
 *                     property="picture",
 *                     type="file",
 *                     description="Image file for the post"
 *                 ),
 *             ),
 *         ),
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Post stored successfully",
 *         @OA\JsonContent(
 *             type="array",
 *             @OA\Items(
 *                 type="object",
 *                 @OA\Property(property="id", type="integer"),
 *                 @OA\Property(property="title", type="string"),
 *                 @OA\Property(property="description", type="string"),
 *                 @OA\Property(property="picture", type="string"),
 *                 @OA\Property(property="created_at", type="string"),
 *                 @OA\Property(property="updated_at", type="string"),
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=422,
 *         description="Validation error",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="message", type="string"),
 *             @OA\Property(property="errors", type="object"),
 *         ),
 *     ),
 * )
 */
public function store(Request $request)
    {
        // Validate the incoming request
        $this->validate($request, [
            'title' => 'required|max:255',
            'description' => 'required',
            'picture' => 'image|nullable|max:1999'
        ]);

        // Handle file upload
        if ($request->hasFile('picture')) {
            // Get the file name with extension
            $filenameWithExt = $request->file('picture')->getClientOriginalName();

            // Get just the filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);

            // Get just the extension
            $extension = $request->file('picture')->getClientOriginalExtension();

            // Create a unique filename to store
            $filenameToStore = $filename . '_' . time() . '.' . $extension;

            // Store the image
            $path = $request->file('picture')->storeAs('public/posts_images', $filenameToStore);
        } else {
            // If no image is provided, set a default filename
            $filenameToStore = 'noimage.png';
        }

        // Create a new post instance
        $post = new Post;
        $post->title = $request->input('title');
        $post->description = $request->input('description');
        $post->picture = $filenameToStore;

        // Save the post to the database
        $post->save();

        // Redirect or respond as needed
        return redirect('gallery')->with('success', 'Image uploaded and post created successfully.');
    }

}
