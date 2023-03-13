<?php

namespace Database\Seeders;

use App\Http\Controllers\User\UserDAO;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {

        $UserDAO = new UserDAO();
        // Start Admin
        $UserDAO->createUserAdmin('Yusman','yusman','yusman@spakat.com', 'asdqwe123', '01', 'is_jkr', '0123456789');
        $UserDAO->createUserAdmin('Administrator','admin','admin@spakat.com', '1O1Ocub$x$', '01', 'is_jkr', '0123456789');
        // End Admin

        // Start Top Management
        $UserDAO->createUserTopMngt('Top Management','top_management','top_management@tera.com', 'asdqwe123', '02', 'is_jkr', '0123456789');
        // End Top Management

        // Start Engineer
        $UserDAO->createUserEngineer('Jurutera','jurutera','smawealthenergy@gmail.com', 'asdqwe123', '01', 'is_jkr', '0123456789','03');

        //Penyenggaraan
        $UserDAO->createUserEngineer('Mohd Azlan Bin Umar','azlan','azlan@jkr.com.my', 'asdqwe123', '01', 'is_jkr', '0123456789', '11');
        // End Engineer

         // Start Assistant Engineer
         //default
         $UserDAO->createUserAssistEngineer('Penolong Jurutera','pen.jurutera','farid.developer.1992@gmail.com', 'asdqwe123', '01', 'is_jkr', '0123456789', '04');
         $UserDAO->createUserAssistEngineer('SUHAIZAI BIN SAAD','suhaizai','suhaizai@gmail.com', 'asdqwe123', '01', 'is_jkr', '0123456789', '04');

         //Penyenggaraan
         $UserDAO->createUserAssistEngineer('Razman Bin Sabtu','razman','razman@jkr.com.my', 'asdqwe123', '01', 'is_jkr', '0123456789', '12');
         $UserDAO->createUserAssistEngineer('Asmawe Bin Abd Wahab','asmawe','asmawe@jkr.com.my', 'asdqwe123', '01', 'is_jkr', '0123456789', '12');
         $UserDAO->createUserAssistEngineer('Nazri','nazri','nazri@jkr.com.my', 'asdqwe123', '01', 'is_jkr', '0123456789','12');
         // End Assistant Engineer

         // Start User Public
         $UserDAO->createUserPublic('MUHAMMAD ALI BIN CHUCK NORRIS','ali','ali@awam.com', 'asdqwe123', '01', 'is_public', '0147897891');
         $UserDAO->createUserPublic('RAMDAN BIN MOHAMMAD ABDULLAH','ramdan','ramdam@awam.com', 'asdqwe123', '01', 'is_contractor', '0147897891');
         // End User Public

         // Start Agensi Kerajaan (Selain JKR)
         $UserDAO->createUserPublicGovAgency('POLIS 01','polis01','polis01@pdrm.gov', 'asdqwe123', '01', '04', 'IBU PEJABAT POLIS MALAYSIA', 'IPPM KAJANG', '47100', '14', 'is_gover_agency', '0147897891');
         $UserDAO->createUserPublicGovAgency('POLIS 02','polis02','polis02@pdrm.gov', 'asdqwe123', '01', '04', 'IBU PEJABAT POLIS MALAYSIA', 'IPPM KAJANG', '47100', '14', 'is_gover_agency', '0147897891');
         $UserDAO->createUserPublicGovAgency('ADNAN MUSTAFA BIN AHMAD ALBAB','adnan','muhdamin1997.ma@gmail.com', 'asdqwe123', '01', '04', 'IBU PEJABAT POLIS MALAYSIA', 'IPPM KAJANG', '47100', '12', 'is_gover_agency', '0147897891');
         $UserDAO->createUserPublicGovAgency('FADZILAH ABDULLAH BIN MAT TAHIR','fadzilah','polis04@pdrm.gov', 'asdqwe123', '01', '04', 'IBU PEJABAT POLIS MALAYSIA', 'IPPM KAJANG', '47100', '12', 'is_gover_agency', '0147897891');
         // End Start Agensi Kerajaan (Selain JKR)

        // Start Create Driver
        $UserDAO->createUserDriver('Driver 1','driverawam1','driver1@awam.com', 'asdqwe123', '01', 'is_jkr', '0147897891');
        $UserDAO->createUserDriver('Driver 2','driverawam2','driver2@awam.com', 'asdqwe123', '01', 'is_jkr', '0147897892');
        $UserDAO->createUserDriver('Driver 3','driverawam3','driver3@awam.com', 'asdqwe123', '01', 'is_jkr', '0147897893');
        $UserDAO->createUserDriver('Driver 4','driverawam4','driver4@awam.com', 'asdqwe123', '01', 'is_jkr', '0147897894');
        $UserDAO->createUserDriver('Pemandu Gantian','pemandugantian','driver5@awam.com', 'asdqwe123', '01', 'is_jkr', '0147897895');
        // End Create Driver

        // Start Senior Engineer
        $UserDAO->createUserSeniorEngineer('Jurutera Kanan','jurutera_kanan','spakat10@gmail.com', 'asdqwe123', '01', 'is_jkr', '0147897891', '09');

        //Penyenggaraan
        $UserDAO->createUserSeniorEngineer('Mohamad Nizam Bin Ibrahim','nizam','nizam@jkr.com.my', 'asdqwe123', '01', 'is_jkr', '0147897891', '10');
        // End Senior Engineer


        // start Create Pembantu Kemahiran

        //Johor
        $UserDAO->createUserForemenAssessment('Pembantu Kemahiran Selangor 01','pemkem.johor','pemkem.johor@spakat.com','asdqwe123','03', '0198976789');

        //Selangor
        $UserDAO->createUserForemenAssessment('MOHD AMIR HAMZAH BIN JUFFRI','pemkem','pemkem.selangor@spakat.com','asdqwe123','11', '0134564563');
        $UserDAO->createUserForemenAssessment('Pembantu Kemahiran Selangor 02','pemkem1','pemkem1.selangor@spakat.com','asdqwe123','11', '0165553344');


        //WP Kuala Lumpur
        $UserDAO->createUserForemenAssessment('MOHD AMIN BIN DOLLAH','amin','aidibakhtiar@me.com','asdqwe123','01', '0134564563');
        $UserDAO->createUserForemenAssessment('MOHD GHAZALI BIN ABDUL GHANI','ghazali','spakat2.test@gmai.com','asdqwe123','01', '0134564563');
        $UserDAO->createUserForemenAssessment('SULAIMAN BIN ABDULLAH','sulaiman','spakat3.test@gmai.com','asdqwe123','01', '0134564563');
        $UserDAO->createUserForemenAssessment('ODDEY XANDRIA','oddey','spakat4.test@gmai.com','asdqwe123','01', '0134564563');
        $UserDAO->createUserForemenAssessment('YUSRI BIN YAHAYAH','yusri','spakat5.test@gmai.com','asdqwe123','01', '0134564563');
        $UserDAO->createUserForemenAssessment('NOR HAMIZAH BINTI HAMID','hamizah','spakat6.test@gmai.com','asdqwe123','01', '0134564563');
        // $UserDAO->createUserForemenAssessment('MAZ AYU IDAWATI BINTI ZAKARIA','ayu','spakat7.test@gmai.com','asdqwe123','01', '0134564563');

        //Penyelenggaraan->Pemeriksaan
        $UserDAO->foremanMaintenanceEva('Penyelenggaraan Pemeriksaan Selangor 03','pemkem3','pemkem3.selangor@spakat.com','asdqwe123','11', '0135514320');
        $UserDAO->foremanMaintenanceEva('Azraf','azraf','azraf.selangor@jkr.com.my','asdqwe123','01', '0135514320');
        // end Create Pembantu Kemahiran

        //User Penilaian
        $UserDAO->createUserEngineer('MOHD AMIRUL ASWAD BIN KHAIRUDDIN','amirul','aidi@cubixi.com', 'asdqwe123', '01', 'is_jkr', '0123456789', '14');
        $UserDAO->createUserAssistEngineer('MOHD RAMADY BIN MOHD ZAINUL','ramady','aidibakhtiar@gmail.com', 'asdqwe123', '01', 'is_jkr', '0123456789', '15');

        // $UserDAO->createUserCoordinator('MOHD RAMADY BIN MOHD ZAINUL','ramady','aidibakhtiar@gmail.com', 'asdqwe123', '01', 'is_jkr', '0123456789', '17');
        //User migrasi jkr
        $UserDAO->createUserPublic('SSO JAMAL KAMALUDDIN','jamal','jamal@awam.com', 'asdqwe123', '01', 'is_public_jkr', '0147897891');
        $UserDAO->createUserPublic('SSO ONG KIT SIANG','ong','ong@awam.com', 'asdqwe123', '01', 'is_public_jkr', '0147897891');
    }
}
