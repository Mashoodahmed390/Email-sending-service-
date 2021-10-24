<?php
$body = [
    'Messages' => [
        [
        'From' => [
            'Email' => "iamkaithebest@gmail.com",
            'Name' => "Mashood ahmed"
        ],
        'To' => [
            [
                'Email' => "iamkaithebest@gmail.com",
                'Name' => "Mashood ahmed"
            ]
        ],
        'Subject' => "Greetings from Mailjet.",
        'HTMLPart' => "<h3>Dear User, welcome to Mailjet!</h3><br />May the delivery force be with you!"
        ]
    ]
];
  
$ch = curl_init();
  
curl_setopt($ch, CURLOPT_URL, "https://api.mailjet.com/v3.1/send");
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($body));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
    'Content-Type: application/json')
);
curl_setopt($ch, CURLOPT_USERPWD, "d5b0192304df36d3619a181998d7d071:a412278bf504580738b9d0f0492fb4e6");
$server_output = curl_exec($ch);
curl_close ($ch);
  
$response = json_decode($server_output);
if ($response->Messages[0]->Status == 'success') {
    echo "Email sent successfully.";
}