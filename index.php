<?php
include 'Telegram.php';
$telegram = new Telegram('7654862668:AAGuDo1pJr_F4ZqHeR8zw5dc2zJi6wWJFbU');

// تنظیمات پرداخت
$paymentConfig = [
    'card' => '6063-7233-0987',
    'bank' => 'بانک ملی',
    'owner' => 'آکادمی موفقیت',
    'amount' => '5,000,000 ریال'
];

// استایل پیام‌ها
function createMessage($type) {
    global $paymentConfig;
    
    $messages = [
        'welcome' => "🌟 *آکادمی موفقیت* 🌟\n\n"
                   ."به سامانه پرداخت هوشمند خوش آمدید\n\n"
                   ."لطفاً گزینه مورد نظر را انتخاب کنید:",
        
        'payment' => "💳 *اطلاعات پرداخت* 💳\n\n"
                   ."┌──────────────────┬─────────────────┐\n"
                   ."│ ▪️ بانک          │ {$paymentConfig['bank']} │\n"
                   ."├──────────────────┼─────────────────┤\n"
                   ."│ ▪️ شماره کارت   │ `{$paymentConfig['card']}` │\n"
                   ."├──────────────────┼─────────────────┤\n"
                   ."│ ▪️ مبلغ         │ {$paymentConfig['amount']} │\n"
                   ."└──────────────────┴─────────────────┘\n\n"
                   ."💰 لطفاً مبلغ را واریز و فیش را ارسال کنید",
        
        'help' => "📘 *راهنمای پرداخت* 📘\n\n"
                 ."1. گزینه پرداخت را انتخاب کنید\n"
                 ."2. مبلغ را به شماره کارت واریز کنید\n"
                 ."3. تصویر فیش را ارسال نمایید\n"
                 ."4. کد پیگیری را حفظ کنید"
    ];
    
    return $messages[$type];
}

// پردازش پیام‌ها
$chat_id = $telegram->ChatID();
$text = $telegram->Text();

if ($text == '/start') {
    $keyboard = $telegram->buildKeyBoard([
        ["💵 پرداخت شهریه"],
        ["📚 راهنمای پرداخت"],
        ["📞 پشتیبانی"]
    ], true, true);
    
    $telegram->sendMessage([
        'chat_id' => $chat_id,
        'text' => createMessage('welcome'),
        'parse_mode' => 'Markdown',
        'reply_markup' => $keyboard
    ]);
}
elseif ($text == '💵 پرداخت شهریه') {
    $telegram->sendMessage([
        'chat_id' => $chat_id,
        'text' => createMessage('payment'),
        'parse_mode' => 'Markdown',
        'reply_markup' => $telegram->buildKeyBoard([
            ["✅ پرداخت انجام شد"],
            ["🔙 منوی اصلی"]
        ], true, true)
    ]);
}
elseif ($text == '📚 راهنمای پرداخت') {
    $telegram->sendMessage([
        'chat_id' => $chat_id,
        'text' => createMessage('help'),
        'parse_mode' => 'Markdown'
    ]);
}
?>