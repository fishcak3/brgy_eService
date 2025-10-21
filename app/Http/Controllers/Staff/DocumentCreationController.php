<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DocumentCreationController extends Controller
{
    // Barangay Clearance
    public function createBarangayClearance()
    {
        return view('certificates.clearance.create');
    }

    // Certificate of Residency
    public function createResidency()
    {
        return view('certificates.residency.create');
    }

    // Certificate of Indigency
    public function createIndigency()
    {
        return view('certificates.indigency.create');
    }

    // Business Permit
    public function createBusinessPermit()
    {
        return view('permits.business.create');
    }
}
