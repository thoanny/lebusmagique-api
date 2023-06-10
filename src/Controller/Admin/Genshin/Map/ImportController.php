<?php

namespace App\Controller\Admin\Genshin\Map;

use App\Entity\Genshin\Map\Marker;
use App\Form\Admin\Genshin\Map\ImportType;
use App\Repository\Genshin\Map\GroupRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ImportController extends AbstractController
{
    #[Route('/admin/genshin/maps/import', name: 'app_admin_genshin_maps_markers_import')]
    #[IsGranted('ROLE_ADMIN')]
    public function index(Request $request, GroupRepository $groupRepository, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(ImportType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->get('data')->getData();
            $data = json_decode($data);

            $group = $groupRepository->findOneBy(['id' => $form->get('group')->getData()]);
            $format = $data->format;

            foreach($data->markers as $m) {

                if(isset($m->format)) {
                    $format = $m->format;
                }

                $marker = (new Marker())
                    ->setActive(false)
                    ->setTitle( (isset($m->title)) ? $m->title : str_replace('##', (int) $m->id, $form->get('title')->getData()) )
                    ->setMarkerGroup($group)
                    ->setX($m->coords[0])
                    ->setY($m->coords[1]);

                if(isset($m->format)) {
                    $marker->setFormat($m->format);
                }

                if(isset($m->text)) {
                    $marker->setText($m->text);
                }

                if(isset($m->guide)) {
                    $marker->setGuide($m->guide);
                }

                if($format === 'video' && isset($m->video)) {
                    $marker->setVideo('https://youtu.be/'.$m->video);
                }

                if($format === 'image') {
                    $image = @file_get_contents('https://gaming.lebusmagique.fr/genshin-impact-carte-interactive/assets/img/medias/'.$form->get('map')->getData().$data->id.$m->id.'.jpg');
                    if($image) {
                        $filename = uniqid().'.jpg';
                        file_put_contents('uploads/api/genshin/maps/medias/'.$filename, $image);
                        $marker->setImageName($filename);
                        $marker->setImageSize(strlen($image));
                    }
                }

                $em->persist($marker);
            }

            $em->flush();
            $this->addFlash('success', 'Marqueurs importés');
            return $this->redirectToRoute('app_admin_genshin_maps_markers_import');
        }

        return $this->render('admin/genshin/map/import/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
