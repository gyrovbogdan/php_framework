<?php


declare(strict_types=1);

namespace App\Services;

use Framework\Validator;
use Framework\Rules\{
    DataFormatRule,
    RequiredRule,
    EmailRule,
    FileErrorRule,
    FileTypeRule,
    MinRule,
    InRule,
    MatchRule,
    UrlRule,
    PasswordRule,
    LengthMaxRule,
    NumericRule,
    ValidFileNameRule
};

class ValidatorService
{
    private Validator $validator;

    public function __construct()
    {
        $this->validator = new Validator();
        $this->validator->add('required', new RequiredRule());
        $this->validator->add('email', new EmailRule());
        $this->validator->add('min', new MinRule());
        $this->validator->add('in', new InRule());
        $this->validator->add('url', new UrlRule());
        $this->validator->add('match', new MatchRule());
        $this->validator->add('password', new PasswordRule());
        $this->validator->add('lengthMax', new LengthMaxRule());
        $this->validator->add('numeric', new NumericRule());
        $this->validator->add('dateFormat', new DataFormatRule());
        $this->validator->add('fileTypeIn', new FileTypeRule());
        $this->validator->add('fileError', new FileErrorRule());
        $this->validator->add('validFileName', new ValidFileNameRule());
    }

    public function validateRegister($formData, &$errors)
    {
        $this->validator->validate($formData, [
            'email' => ['required', 'email'],
            'age' => ['required', 'min:18'],
            'country' => ['required', 'in:USA,Canada,Mexico'],
            'socialMediaURL' => ['required', 'url'],
            'password' => ['required', 'password'],
            'confirmPassword' => ['required', 'match:password'],
            'tos' => ['required'],
        ], $errors);
    }

    public function validateLogin($formData, &$errors)
    {
        $this->validator->validate($formData, [
            'email' => ['required', 'email'],
            'password' => ['required']
        ], $errors);
    }

    public function validateTransactions($formData, &$errors)
    {
        $this->validator->validate($formData, [
            'description' => ['required', 'lengthMax:255'],
            'amount' => ['required', 'numeric'],
            'date' => ['required', 'dateFormat']
        ], $errors);
    }

    public function validateReceipt($formData, &$errors)
    {
        $valid = $this->validator->validate($formData, [
            'receipt' => ['required']
        ], $errors);

        if (!$valid)
            return;

        $valid = $this->validator->validate($formData['receipt'], [
            'error' => ['fileError'],
        ], $errors);

        if (!$valid)
            return;

        $valid = $this->validator->validate($formData['receipt'], [
            'name' => ['validFileName'],
            'type' => ['fileTypeIn:png,jpg,pdf,jpeg'],
        ], $errors);
    }
}
