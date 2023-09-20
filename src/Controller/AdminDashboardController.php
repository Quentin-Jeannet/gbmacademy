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
        $inscrit = $participantRepository->findByRaisonNull();
        return $this->render('admin_dashboard/index.html.twig', [
            'pasInteresse' => count($pasInteresse),
            'pasDisponible' => count($pasDisponible),
            'desinscrit' => count($desinscrit),
            'inscrit' => count($inscrit),
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

        $participants = $participantRepository->findByRaisonNotNull();
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

    #[Route('/admin/dashboard/export/inscription', name: 'app_admin_dashboard_export_inscription')]
    public function exportInscrit(ParticipantRepository $participantRepository)
    {


        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle("Participants");
        // Mise en place des entêtes
        $sheet->getCell('A1')->setValue("Nom");
        $sheet->getCell('B1')->setValue('Prénom');
        $sheet->getCell('C1')->setValue('Titre');
        $sheet->getCell('D1')->setValue('Civilité');
        $sheet->getCell('E1')->setValue('Email');
        $sheet->getCell('F1')->setValue("N° de téléphone");
        $sheet->getCell('G1')->setValue('Date de naissance');
        $sheet->getCell('H1')->setValue('Hopital');
        $sheet->getCell('I1')->setValue('Spécialité');
        $sheet->getCell('J1')->setValue('Service');
        $sheet->getCell('K1')->setValue('Ville');
        $sheet->getCell('L1')->setValue('N° RPPS');
        $sheet->getCell('M1')->setValue('Certificat de présence');
        $sheet->getCell('N1')->setValue('Hébergement');
        $sheet->getCell('O1')->setValue('Transport');
        $sheet->getCell('P1')->setValue('Newsletter');

        $participants = $participantRepository->findByRaisonNull();

        $i = 2;
        foreach ($participants as $participant) {
            $sheet->setCellValue('A' . $i, $participant->getNom());
            $sheet->setCellValue('B' . $i, $participant->getPrenom());
            $sheet->setCellValue('C' . $i, $participant->getTitre());
            $sheet->setCellValue('D' . $i, $participant->getCivilite());
            $sheet->setCellValue('E' . $i, $participant->getEmail());
            $sheet->setCellValue('F' . $i, $participant->getTelephone());
            $sheet->setCellValue('G' . $i, $participant->getDateNaissance() ? $participant->getDateNaissance()->format('d/m/Y') : '');
            $sheet->setCellValue('H' . $i, $participant->getHopital());
            $sheet->setCellValue('I' . $i, $participant->getSpecialite());
            $sheet->setCellValue('J' . $i, $participant->getService());
            $sheet->setCellValue('K' . $i, $participant->getVille());
            $sheet->setCellValue('L' . $i, $participant->getNumRPPS());
            $sheet->setCellValue('M' . $i, $participant->isCertificat() ? 'Oui' : 'Non');
            $sheet->setCellValue('N' . $i, $participant->isHebergement() ? 'Oui' : 'Non');
            $sheet->setCellValue('O' . $i, $participant->isTransport() ? 'Oui' : 'Non');
            $sheet->setCellValue('P' . $i, $participant->isOnNewsLetter() ? 'Oui' : 'Non');
            $i++;
        }

        for ($i = 'A'; $i <=  $sheet->getHighestColumn(); $i++) {
            $sheet->getColumnDimension($i)->setAutoSize(TRUE);
        }

        $writer = new Xlsx($spreadsheet);
        $path = 'xls/export_user_inscrit.xlsx';
        $writer->save($path);

        return $this->redirect('/' . $path);

    }
}
