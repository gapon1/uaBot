<?php


namespace App\Controller;


use App\Service\MarkdownHelper;
use App\Service\SlackClient;
use Nexy\Slack\Client;
use Psr\Log\LoggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ArticleController extends AbstractController
{

    /**
     * Dont use. just for example
     */
    private $isDebug;

    public function __construct(bool $isDebug)
    {
        $this->isDebug = $isDebug;
    }

    /**
     * @Route("/", name="app_homepage")
     */
    public function homepage()
    {
        return $this->render('article/homepage.html.twig');
    }

    /**
     * @Route("/news/{slug}", name="article_show")
     */
    public function show($slug, MarkdownHelper $markdownHelper, SlackClient $slackClient)
    {

        if ($slug === 'khaaaaaan') {
            $slackClient->sendMessage('Tets', 'Hello how are you fron yesy?');
        }

        $comments = [
            'I ate a normal rock once. It did NOT taste like bacon!',
            'Woohoo! I\'m going on an all-asteroid diet!',
            'I like bacon too! Buy some from my site! bakinsomebacon.com',
        ];


        $articleContent = <<<EOF
Многие думают, **что Lorem Ipsum** - взятый с потолка псевдо-латинский набор слов, 
но это не совсем так. bacon Его корни уходят в один фрагмент классической латыни 45 года 
н.э., то есть более двух тысячелетий назад. Ричард МакКлинток, профессор латыни из 
колледжа Hampden-Sydney, штат **Вирджиния**, взял одно из самых странных слов в
 
 Lorem Ipsum, "consectetur", и занялся его поисками в классической латинской литературе.
  В результате он нашёл неоспоримый первоисточник Lorem Ipsum в разделах 1.10.32 и 1.10.33 книги 
  "de Finibus Bonorum et Malorum" ("О пределах добра и зла"), написанной Цицероном в 45 году н.э. 
  Этот трактат по теории этики был очень популярен в эпоху Возрождения. Первая строка Lorem Ipsum,
 "Lorem ipsum dolor sit amet..", происходит от одной из строк в разделе 1.10.32


EOF;

        $articleContent = $markdownHelper->parse($articleContent);

        return $this->render(
            'article/show.html.twig',
            [
                'title' => ucwords(str_replace('-', '', $slug)),
                'comments' => $comments,
                'articleContent' => $articleContent,
                'slug' => $slug,
            ]
        );

    }

    /**
     * @Route("/news/{slug}/heart", name="article_toggle_heart", methods={"POST"})
     */
    public function toggleArticleHeart($slug, LoggerInterface $logger)
    {
        $logger->info("Logger Art Hearted");

        return new JsonResponse(['heart' => rand(5, 100)]);

    }

}