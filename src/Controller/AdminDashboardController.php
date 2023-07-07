<?php

namespace App\Controller;

use App\Repository\ParticipantRepository;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminDashboardController extends AbstractController
{
    #[Route('/admin', name: 'app_admin_dashboard')]
    public function index(ParticipantRepository $participantRepository): Response
    {
        $pasInteresse = $participantRepository->findBy(['raison' => 'Pas intéressé']);
        $pasDisponible = $participantRepository->findBy(['raison' => 'Pas disponible']);
        $desinscrit = $participantRepository->findBy(['onNewsLetter' => false]);
        return $this->render('admin_dashboard/index.html.twig', [
            'pasInteresse' => count($pasInteresse),
            'pasDisponible' => count($pasDisponible),
            'desinscrit' => count($desinscrit),
        ]);
    }

    #[Route('/admin/dashboard/export', name: 'app_admin_dashboard_export')]
    public function export(ParticipantRepository $participantRepository)
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Nom');
        $sheet->setCellValue('B1', 'Prénom');
        $sheet->setCellValue('C1', 'Email');
        $sheet->setCellValue('D1', 'Raison');
        $sheet->setCellValue('E1', 'Newsletter');

        $participants = $participantRepository->findAll();
        $i = 2;
        foreach ($participants as $participant) {
            $sheet->setCellValue('A' . $i, $participant->getNom());
            $sheet->setCellValue('B' . $i, $participant->getPrenom());
            $sheet->setCellValue('C' . $i, $participant->getEmail());
            $sheet->setCellValue('D' . $i, $participant->getRaison());
            $sheet->setCellValue('E' . $i, $participant->isOnNewsLetter() ? 'Oui' : 'Non');
            $i++;
        }

        for ($i = 'A'; $i <=  $sheet->getHighestColumn(); $i++) {
            $sheet->getColumnDimension($i)->setAutoSize(TRUE);
        }

        $writer = new Xlsx($spreadsheet);
        $path = 'xls/export_user.xlsx';
        $writer->save($path);

        return $this->redirect('/'. $path);

        
    }
}
