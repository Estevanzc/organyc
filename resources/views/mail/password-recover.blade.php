@component('mail::message')
# Hello, {{ $user->name }}!

You are receiving this email because we received a password reset request for your account.

Click the button below to reset your password:

@component('mail::button', ['url' => $reset_url, 'color' => 'primary'])
Reset Password
@endcomponent

This password reset link will expire in 60 minutes.

If you did not request a password reset, no further action is required and you can safely disregard this email.

Thanks,<br>
The Organyc Team
@endcomponent