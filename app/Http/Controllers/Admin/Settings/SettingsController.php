<?php

namespace App\Http\Controllers\Admin\Settings;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Mail;

class SettingsController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    /**
     * Display the settings page.
     */
    public function index()
    {
        return $this->edit();
    }

    /**
     * Display the settings edit form.
     */
    public function edit()
    {
        $settings = [
            'general' => Setting::getByGroup('general'),
            'email' => Setting::getByGroup('email'),
            'rental' => Setting::getByGroup('rental'),
            'payment' => Setting::getByGroup('payment'),
        ];

        return view('admin.settings.index', compact('settings'));
    }

    /**
     * Update the settings.
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'site_name' => 'required|string|max:255',
            'site_description' => 'nullable|string|max:1000',
            'contact_email' => 'required|email',
            'support_phone' => 'nullable|string|max:20',
            'rental_terms' => 'nullable|string',
            'minimum_rental_days' => 'required|integer|min:1',
            'maximum_rental_days' => 'required|integer|min:1',
            'deposit_percentage' => 'required|numeric|min:0|max:100',
            'currency' => 'required|string|size:3',
            'mail_driver' => 'required|string',
            'mail_host' => 'required|string',
            'mail_port' => 'required|integer',
            'mail_username' => 'required|string',
            'mail_password' => 'required|string',
            'mail_encryption' => 'required|string',
            'mail_from_address' => 'required|email',
            'mail_from_name' => 'required|string',
        ]);

        // Update general settings
        Setting::set('site_name', $validated['site_name'], 'string', 'general');
        Setting::set('site_description', $validated['site_description'], 'string', 'general');
        Setting::set('contact_email', $validated['contact_email'], 'string', 'general');
        Setting::set('support_phone', $validated['support_phone'], 'string', 'general');

        // Update rental settings
        Setting::set('rental_terms', $validated['rental_terms'], 'text', 'rental');
        Setting::set('minimum_rental_days', $validated['minimum_rental_days'], 'integer', 'rental');
        Setting::set('maximum_rental_days', $validated['maximum_rental_days'], 'integer', 'rental');
        Setting::set('deposit_percentage', $validated['deposit_percentage'], 'float', 'rental');
        Setting::set('currency', $validated['currency'], 'string', 'rental');

        // Update email settings
        $emailSettings = [
            'driver' => $validated['mail_driver'],
            'host' => $validated['mail_host'],
            'port' => $validated['mail_port'],
            'username' => $validated['mail_username'],
            'password' => $validated['mail_password'],
            'encryption' => $validated['mail_encryption'],
            'from' => [
                'address' => $validated['mail_from_address'],
                'name' => $validated['mail_from_name'],
            ],
        ];
        Setting::set('mail_config', $emailSettings, 'array', 'email');

        return redirect()->route('admin.settings.index')
            ->with('success', 'Settings updated successfully.');
    }

    /**
     * Clear application cache.
     */
    public function clearCache()
    {
        Artisan::call('cache:clear');
        Artisan::call('config:clear');
        Artisan::call('view:clear');
        Setting::clearCache();

        return back()->with('success', 'Cache cleared successfully.');
    }

    /**
     * Send test email.
     */
    public function testEmail(Request $request)
    {
        $request->validate([
            'test_email' => 'required|email'
        ]);

        try {
            Mail::raw('This is a test email from Smart Rental Hub.', function($message) use ($request) {
                $message->to($request->test_email)
                    ->subject('Test Email from Smart Rental Hub');
            });

            return back()->with('success', 'Test email sent successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to send test email: ' . $e->getMessage());
        }
    }
} 