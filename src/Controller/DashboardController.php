<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Bookings;

class DashboardController extends AbstractController
{
    public function index()
    {
        $appointments = $this->getDoctrine()->getRepository(Bookings::class)->getBookings();
        return $this->render('dashboard/index.html.twig', [
            'appointments' => $appointments,
        ]);
    }
    
    public function deleteAppointment($id) {
        $appointment = $this->getDoctrine()->getRepository(Bookings::class)->findOneBy(['id' => intval($id)]);
        if ($appointment) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($appointment);
            $em->flush();
            $this->addFlash('success', 'Appointment deleted successfully.');
        } else {
            $this->addFlash('error', 'Appointment doesn\'t exists.');
        }
        return $this->redirect($this->generateUrl('dashboard'));
    }
}
