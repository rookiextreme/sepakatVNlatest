<?php

namespace Database\Seeders;

use App\Models\LogisticBookingStatus;
use App\Models\LogisticBookingVehicleStatus;
use App\Models\LogisticStayStatus;
use App\Models\Maintenance\MaintenanceEvaluationLetterStatus;
use App\Models\Maintenance\MaintenanceInspectionType;
use App\Models\Maintenance\MaintenanceJobPurposeType;
use App\Models\RefCategory;
use App\Models\RefComponentChecklistLvl1;
use App\Models\RefDisposal;
use App\Models\RefSelection;
use App\Models\RefTableSelection;
use App\Models\RefVehicleStatus;


use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        $this->call([
            RolesSeeder::class,
            RefRoleAccessSeeder:: class,
            RefStateSeeder::class,
            RefWorkshopSeeder::class,
            RefRoleSeeder::class,
            RefStatusSeeder::class,
            RefAgencySeeder::class,
            // PermissionSeeder::class,
            IdentityTypeSeeder::class,
            JawatanSeeder::class,
            NegeriSeeder::class,
            DaerahSeeder::class,
            LocationPlacementSeeder::class,
            CawanganSeeder::class,
            KementerianSeeder::class,
            JabatanSeeder::class,
            UserSeeder::class,
            RefCategorySeeder::class,
            RefSubCategorySeeder::class,
            RefSubCategoryTypeSeeder::class,
            BrandSeeder::class,
            RefSummonAgencySeeder::class,
            RefSummonTypeSeeder::class,
            VehicleModelSeeder::class,
            KenderaanStatusSeeder::class,
            SummonStatusSeeder::class,
            ModuleSeeder:: class,
            ModuleSubSeeder:: class,
            ModuleSubAccessSeeder::class,
            TaskFlowSeeder::class,
            TaskFlowSubSeeder::class,
            TaskFlowSubAccessSeeder::class,
            RefOwnerTypeSeeder::class,
            RefOwnerSeeder::class,
            RefOwnerUserSeeder::class,
            // DaftarKenderaanSeeder::class,
            RefSectorSeeder::class,
            RefBranchSeeder::class,
            RefDivisionSeeder::class,
            RefUnitSeeder::class,
            RefVehicleStatusSeeder::class,
            RefEventSeeder::class,
            FleetPlacementSeeder::class,

            DaftarKenderaanSeederDepartment::class,
            RefSettingSeeder::class,
            RefSettingSubSeeder:: class,
            AssessmentTypeSeeder:: class,
            RefComponentLvl1Seeder::class,
            RefComponentLvl2Seeder::class,
            // RefComponentLvl3Seeder::class,

            RefTableSelectionSeeder::class,
            RefSelectionSeeder::class,

            RefComponentChecklistLvl1Seeder::class,
            AssessmentFormCheckLvl1SelectionSeeder::class,
            RefComponentChecklistLvl2Seeder::class,
            RefComponentChecklistLvl3Seeder::class,

            FleetDisposalSeeder::class,
            FleetProjectSeeder::class,

            RefTypeAnnouncementSeeder::class,
            SettingAnnouncementSeeder::class,

            LogisticDisasterReadyStatusSeeder::class,
            LogisticBookingStatusSeeder::class,
            LogisticStayStatusSeeder::class,
            LogisticVehicleStatusSeeder::class,

            RefDisposalSeeder::class,

            MaintenanceStatusSeeder::class,
            MaintenanceTypeSeeder::class,
            WaranTypeSeeder::class,
            OsolTypeSeeder::class,


            SamanSeeder::class,

            AssessmentOwnershipSeeder::class,

            AssessmentApplicationStatusSeeder::class,

            AssessmentVehicleStatusSeeder::class,
            // AssessmentNewSeeder::class,
            // AssessmentNewVehicleSeeder::class,

            RefEngineCoolerTypeSeeder::class,
            RefEngineFuelTypeSeeder::class,
            RefEngineTypeSeeder::class,
            RefRecheckTypeSeeder::class,
            RefSteeringTypeSeeder::class,
            RefSuspensionTypeSeeder::class,
            RefTransmissionTypeSeeder::class,
            DisposalPercentageSeeder::class,

            MaintenanceEvaluationLetterTypeSeeder::class,
            MaintenanceEvaluationLetterStatusSeeder::class,

            MaintenanceJobPurposeTypeSeeder::class,

            MaintenanceExternalRepairSeeder::class,
            MaintenanceRepairMethodSeeder::class,

            RefMonitoringSeeder::class,
            MaintenanceJobVehicleStatusSeeder::class,

            //22/09/2021
            // WarrantDetailSeeder::class,
            // WarrantDetail2Seeder::class,

            MaintenanceJobVehicleMaintenanceStatusSeeder::class,

            MaintenanceApplicationStatusTableSeeder::class,
            MaintenanceVehicleStatusTableSeeder::class,
            RefComponentChecklistLvl1TableSeeder::class,
            RefComponentChecklistLvl2TableSeeder::class,
            // MaintenanceJobTableSeeder::class,
            WarrantProjection::class,
            InspectionTypeSeeder::class,

            //view must last part.
            CreateViews::class,
            PatchSeeder::class,
        //    RefRoleTableSeeder::class,
        //    MaintenanceApplicationStatusTableSeeder::class,
        //    MaintenanceEvaluationTableSeeder::class,
        //    MaintenanceVehicleStatusTableSeeder::class,
        //    MaintenanceEvaluationVehicleTableSeeder::class,
        //    RefComponentChecklistLvl1TableSeeder::class,
        //    RefComponentChecklistLvl2TableSeeder::class,
        //    MaintenanceJobTableSeeder::class,
        ]);


        // $this->call(AssessmentNewTableSeeder::class);
        // $this->call(AssessmentNewVehicleTableSeeder::class);
        // $this->call(AssessmentSafetyTableSeeder::class);
        // $this->call(AssessmentSafetyVehicleTableSeeder::class);
        // $this->call(AssessmentCurrvalueTableSeeder::class);
        // $this->call(AssessmentCurrvalueVehicleTableSeeder::class);
        // $this->call(AssessmentGovLoanTableSeeder::class);
        // $this->call(AssessmentGovLoanVehicleTableSeeder::class);
        // $this->call(AssessmentDisposalTableSeeder::class);
        // $this->call(AssessmentDisposalVehicleTableSeeder::class);
    }
}
