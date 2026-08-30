<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use App\Models\Page;
use App\Models\QuotationRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ContactController extends Controller
{
    public function index(): View
    {
        $page = Page::query()
            ->where('slug', 'contact')
            ->where('is_published', true)
            ->with('activeSections')
            ->first();

        $sections = $page
            ? $page->activeSections->keyBy('section_key')
            : collect();

        return view('frontend.pages.contact', compact(
            'page',
            'sections'
        ));
    }

    public function storeMessage(Request $request): RedirectResponse
    {
        if ($request->filled('website')) {
            return back()->with('contact_success', true);
        }

        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:150',
            ],
            'email' => [
                'nullable',
                'email',
                'max:150',
            ],
            'phone' => [
                'required',
                'string',
                'max:50',
            ],
            'company' => [
                'nullable',
                'string',
                'max:150',
            ],
            'subject' => [
                'required',
                'string',
                'max:200',
            ],
            'message' => [
                'required',
                'string',
                'max:5000',
            ],
        ]);

        ContactMessage::create([
            ...$validated,
            'status' => 'new',
            'ip_address' => $request->ip(),
            'user_agent' => Str::limit(
                (string) $request->userAgent(),
                1000
            ),
        ]);

        return redirect()
            ->route('contact')
            ->with(
                'contact_success',
                'Your message has been received. Our team will contact you shortly.'
            );
    }

    public function storeQuotation(Request $request): RedirectResponse
    {
        if ($request->filled('website')) {
            return back()->with('quotation_success', true);
        }

        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:150',
            ],
            'email' => [
                'nullable',
                'email',
                'max:150',
            ],
            'phone' => [
                'required',
                'string',
                'max:50',
            ],
            'company' => [
                'nullable',
                'string',
                'max:150',
            ],
            'service_type' => [
                'required',
                'string',
                'max:150',
            ],
            'project_title' => [
                'required',
                'string',
                'max:200',
            ],
            'project_description' => [
                'required',
                'string',
                'max:7000',
            ],
            'budget' => [
                'nullable',
                'string',
                'max:100',
            ],
            'timeline' => [
                'nullable',
                'string',
                'max:150',
            ],
            'location' => [
                'nullable',
                'string',
                'max:200',
            ],
            'preferred_contact_method' => [
                'nullable',
                'in:phone,email,whatsapp',
            ],
        ]);

        $quotation = QuotationRequest::create([
            ...$validated,
            'reference_number' => $this->generateReferenceNumber(),
            'status' => 'new',
            'ip_address' => $request->ip(),
            'user_agent' => Str::limit(
                (string) $request->userAgent(),
                1000
            ),
        ]);

        return redirect()
            ->route('contact')
            ->with(
                'quotation_success',
                'Your quotation request has been submitted successfully.'
            )
            ->with(
                'quotation_reference',
                $quotation->reference_number
            );
    }

    private function generateReferenceNumber(): string
    {
        do {
            $reference = 'VTL-Q-' .
                now()->format('Ymd') .
                '-' .
                Str::upper(Str::random(6));
        } while (
            QuotationRequest::query()
                ->where('reference_number', $reference)
                ->exists()
        );

        return $reference;
    }
}
