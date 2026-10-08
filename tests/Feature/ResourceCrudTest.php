<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Patient;
use App\Models\Doctor;
use App\Models\Appointment;

class ResourceCrudTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Doctor::factory()->count(5)->create();
    }

    public function test_patient_full_crud_cycle()
    {
        // index
        $resp = $this->get('/patients');
        $resp->assertOk();

        // create
        $resp = $this->post('/patients', [
            'student_id' => 'TEST9999',
            'name' => 'Test Patient',
            'course' => 'BS CS',
            'year_level' => 3,
        ]);
        $resp->assertRedirect('/patients');
        $patient = Patient::where('student_id', 'TEST9999')->first();
        $this->assertNotNull($patient);
        $pid = $patient->id;

        // edit page
        $this->get("/patients/$pid/edit")->assertOk();

        // update
        $resp = $this->put("/patients/$pid", [
            'student_id' => 'TEST9999',
            'name' => 'Updated Patient',
            'course' => 'BS IT',
            'year_level' => 2,
        ]);
        $resp->assertRedirect('/patients');
        $patient->refresh();
        $this->assertSame('Updated Patient', $patient->name);

        // delete
        $resp = $this->delete("/patients/$pid");
        $resp->assertRedirect('/patients');
        $this->assertNull(Patient::find($pid));
    }

    public function test_appointment_full_crud_cycle()
    {
        $patient = Patient::factory()->create();
        $doctor = Doctor::first();

        // index
        $this->get('/appointments')->assertOk();

        // create
        $resp = $this->post('/appointments', [
            'patient_id' => $patient->id,
            'doctor_id' => $doctor->id,
            'appointment_date' => '2026-12-01',
            'status' => 'Scheduled',
        ]);
        $resp->assertRedirect('/appointments');
        $appointment = Appointment::where('patient_id', $patient->id)->first();
        $this->assertNotNull($appointment);
        $aid = $appointment->id;

        // edit page
        $this->get("/appointments/$aid/edit")->assertOk();

        // update
        $resp = $this->put("/appointments/$aid", [
            'patient_id' => $patient->id,
            'doctor_id' => $doctor->id,
            'appointment_date' => '2026-12-15',
            'status' => 'Completed',
        ]);
        $resp->assertRedirect('/appointments');
        $appointment->refresh();
        $this->assertSame('Completed', $appointment->status);

        // delete
        $resp = $this->delete("/appointments/$aid");
        $resp->assertRedirect('/appointments');
        $this->assertNull(Appointment::find($aid));
    }

    public function test_patient_create_requires_fields()
    {
        $resp = $this->post('/patients', []);
        $resp->assertSessionHasErrors(['student_id', 'name', 'course', 'year_level']);
    }

    public function test_appointment_create_requires_fields()
    {
        $resp = $this->post('/appointments', []);
        $resp->assertSessionHasErrors(['patient_id', 'doctor_id', 'appointment_date', 'status']);
    }
}