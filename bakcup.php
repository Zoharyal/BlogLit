  {% set next = chapter.getNextId() %}
            {% set prev = chapter.getPrevId() %}
        <a href="{{path('chapter', {id: next}) }}" class="chapterTitle"><h3 class="title">Chapitre suivant</h3></a>
        <a href="{{path('chapter', {id: prev}) }}" class="chapterTitle"><h3 class="title">Chapitre précedent</h3></a>

errror bkacup
$app->error(function (\Exception $e, Request $request, $code) use ($app) {
    switch ($code) {
        case 403:
            $message = 'Access denied.';
            break;
        case 404:
            $message = 'The requested resource could not be found.';
            break;
        default:
            $message = "Something went wrong.";
    }
    return $app['twig']->render('error.html.twig', array('message' => $message));
});


   <footer><a href="{{path('credit)}}">Crédit</a></footer>