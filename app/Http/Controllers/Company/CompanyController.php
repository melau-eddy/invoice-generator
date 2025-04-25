<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Http\Requests\CompanyRequest;
use App\Models\Company;
use App\Service\CompanyService;
use App\Service\FileService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

/**
 * Class Company Controller
 */
class CompanyController extends Controller
{
    /**
     * @param CompanyService $companyService
     */
    public function __construct(protected CompanyService $companyService, protected FileService $fileService)
    {
    }


    /**
     *Display a listing of the companies.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|void
     */
    public function index(Request $request)
    {
        try {
            $total = intval(ceil(count(Company::all()) / 10));
            $companies = $this->companyService->getCompany($request->all());
            return view('Company.CompanyRetrieve', compact('companies', 'total'));
        } catch (\Exception $exception) {
            Log::error($exception);
            return redirect()->back()->with('error_msg', $exception);
        }
    }


    /**
     * Show the form for creating a new company.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function create()
    {
        try {
            return view('Company.CompanyForm');
        } catch (\Exception $exception) {
            Log::error($exception);
            return redirect()->back()->with('error_msg', $exception);
        }
    }


    /**
     * Store a newly created company in storage.
     *
     * @param CompanyRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CompanyRequest $request)
    {
        try {
            DB::beginTransaction();
            $company = $this->companyService->store([
                "name" => $request->company_name,
                "email" => $request->email,
                "location" => $request->address,
                "number" => $request->phone
            ]);
            $this->fileService->storeFile($company, $request, 'logo', 'company_image', 'company_image');
            DB::commit();
            return redirect()->route('company.index')->with('status', 'New Company Created');
        } catch (\Exception $exception) {
            Log::error($exception);
            return redirect()->back()->with('error_msg', $exception);
        }
    }


    /**
     * Display the specified company.
     *
     * @param Company $company
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function show(Company $company)
    {
        try {
            return view('Company.CompanyRetrieve', compact('company'));
        } catch (\Exception $exception) {
            Log::error($exception);
            return redirect()->back()->with('error_msg', $exception);
        }
    }

    /**
     * Show the form for editing the specified company.
     *
     * @param Company $company
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function edit(Company $company)
    {
        try {
            return view('Company.CompanyForm', compact('company'));
        } catch (\Exception $exception) {
            Log::error($exception);
            return redirect()->back()->with('error_msg', $exception);
        }
    }


    /**
     * Update the specified company in storage.
     *
     * @param CompanyRequest $request
     * @param Company $company
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(CompanyRequest $request, Company $company)
    {
        try {
            DB::beginTransaction();
            $company_update = $this->companyService->find($company->id);
            if ($request->hasFile('logo')) {
                Storage::disk('uploads')->delete($company->company_image);
                $this->fileService->storeFile($company_update, $request, 'logo', 'company_image', 'company_image');
            }
            $this->companyService->update($company->id, [
                "name" => $request->company_name,
                "email" => $request->email,
                "location" => $request->address,
                "number" => $request->phone
            ]);
            DB::commit();
            return redirect()->route('company.index')->with('status', 'Company Details Updated');
        } catch (\Exception $exception) {
            Log::error($exception);
            return redirect()->back()->with('error_msg', $exception);
        }
    }


    /**
     * Remove the specified company from storage.
     *
     * @param Company $company
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Company $company)
    {
        try {
            $this->companyService->destroy($company->id);
            return redirect()->route('company.index')->with('status', 'Company Details Deleted Successfully');
        } catch (\Exception $exception) {
            Log::error($exception);
            return redirect()->back()->with('error_msg', $exception);
        }
    }
}
