<?php

namespace Database\Seeders;

use App\Facades\Utility;
use App\Models\Landlord\Page;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $title1 = 'Privacy Policy';
        $title2 = 'Terms & Conditions';
        $description1 = '<div class="flex flex-grow flex-col gap-3 max-w-full">
                    <div class="min-h-[20px] flex flex-col items-start gap-3 whitespace-pre-wrap break-words overflow-x-auto">
                    <div class="result-streaming markdown prose w-full break-words dark:prose-invert light">
                    <p>Certainly, heres a general outline for the "Terms and Policies" that a software firm might have. Please note that the specific content of these terms and policies should be customized to your firms practices and legal requirements, and its essential to consult with legal professionals to create accurate and compliant documents.</p>
                    <p><strong>Terms and Conditions</strong></p>
                    <p><strong>1. Acceptance of Terms</strong></p>
                    <ul>
                    <li>Introduction explaining that by using the software or services, users agree to be bound by the terms.</li>
                    <li>How changes to the terms will be communicated and the users responsibility to review them periodically.</li>
                    </ul>
                    <p><strong>2. User Accounts</strong></p>
                    <ul>
                    <li>Registration requirements and user account creation.</li>
                    <li>Responsibilities of users regarding their account security and confidentiality.</li>
                    </ul>
                    <p><strong>3. Use of Software and Services</strong></p>
                    <ul>
                    <li>Describe the software or services offered.</li>
                    <li>Usage guidelines and restrictions (e.g., no unauthorized copying, reverse engineering, or illegal activities).</li>
                    </ul>
                    <p><strong>4. Payment and Billing</strong></p>
                    <ul>
                    <li>Details about pricing, payment methods, and billing cycles.</li>
                    <li>Cancellation and refund policies, if applicable.</li>
                    </ul>
                    <p><strong>5. Intellectual Property</strong></p>
                    <ul>
                    <li>Ownership of intellectual property (software, logos, trademarks).</li>
                    <li>Permissions and restrictions on the use of intellectual property.</li>
                    </ul>
                    <p><strong>6. Privacy and Data Security</strong></p>
                    <ul>
                    <li>Reference to the Privacy Policy for data collection and handling.</li>
                    <li>Data protection and security measures in place.</li>
                    </ul>
                    <p><strong>7. User Content</strong></p>
                    <ul>
                    <li>Policies regarding user-generated content (if applicable).</li>
                    <li>Rights to use, remove, or moderate user-generated content.</li>
                    </ul>
                    <p><strong>8. Termination</strong></p>
                    <ul>
                    <li>Grounds for termination of user accounts.</li>
                    <li>Consequences of termination, such as data loss or refund eligibility.</li>
                    </ul>
                    <p><strong>9. Disclaimer of Warranties</strong></p>
                    <ul>
                    <li>Clarify that the software is provided "as is" without warranties.</li>
                    <li>Limitations of liability in case of malfunctions or damages.</li>
                    </ul>
                    <p><strong>10. Limitation of Liability</strong></p>
                    <ul>
                    <li>Specify liability limits, including indirect or consequential damages.</li>
                    <li>Acknowledgment of potential risks and user responsibility.</li>
                    </ul>
                    <p><strong>11. Governing Law and Dispute Resolution</strong></p>
                    <ul>
                    <li>Jurisdiction under which disputes will be resolved.</li>
                    <li>Choice of law and dispute resolution methods (e.g., arbitration or litigation).</li>
                    </ul>
                    <p><strong>12. Changes to Terms</strong></p>
                    <ul>
                    <li>Explain how and when changes to the terms will be made.</li>
                    <li>Notice of changes and how users can accept or reject them.</li>
                    </ul>
                    <p><strong>Privacy Policy</strong></p>
                    <ul>
                    <li>Include a brief link to the</li>
                    </ul>
                    </div>
                    </div>
                    </div>';

        $description2 = '<p><strong>1. Acceptance of Terms</strong></p>
                        <ul>
                        <li>Introduction: Users agree to these terms when using our software or services.</li>
                        <li>Notification of the right to review the terms periodically for changes.</li>
                        </ul>
                        <p><strong>2. User Accounts</strong></p>
                        <ul>
                        <li>User registration requirements.</li>
                        <li>Responsibilities for maintaining account security and confidentiality.</li>
                        <li>Notification of the potential consequences of unauthorized account access.</li>
                        </ul>
                        <p><strong>3. Use of Software and Services</strong></p>
                        <ul>
                        <li>Description of the software and services offered.</li>
                        <li>Guidelines and restrictions on usage, including any prohibited activities (e.g., reverse engineering).</li>
                        </ul>
                        <p><strong>4. Payment and Billing</strong></p>
                        <ul>
                        <li>Pricing details, payment methods, and billing cycles.</li>
                        <li>Cancellation, refund policies, if applicable.</li>
                        </ul>
                        <p><strong>5. Intellectual Property</strong></p>
                        <ul>
                        <li>Declaration of ownership of intellectual property (software, trademarks, logos).</li>
                        <li>Permissions and restrictions on the use of intellectual property.</li>
                        </ul>
                        <p><strong>6. Privacy and Data Security</strong></p>
                        <ul>
                        <li>Reference to the Privacy Policy for data collection and handling.</li>
                        <li>Assurance of data protection and security measures.</li>
                        </ul>
                        <p><strong>7. User-Generated Content (if applicable)</strong></p>
                        <ul>
                        <li>Policies regarding user-generated content (e.g., comments, reviews).</li>
                        <li>Rights to use, remove, or moderate user-generated content.</li>
                        </ul>
                        <p><strong>8. Termination</strong></p>
                        <ul>
                        <li>Grounds for the termination of user accounts.</li>
                        <li>Consequences of termination, such as data loss or refund eligibility.</li>
                        </ul>
                        <p><strong>9. Disclaimer of Warranties</strong></p>
                        <ul>
                        <li>Statement that the software is provided "as is" without warranties.</li>
                        <li>Limitations on liability in case of malfunctions or damages.</li>
                        </ul>
                        <p><strong>10. Limitation of Liability</strong></p>
                        <ul>
                        <li>Specific limits on liability, including disclaimers regarding indirect or consequential damages.</li>
                        <li>Acknowledgment of potential risks and user responsibility.</li>
                        </ul>
                        <p><strong>11. Governing Law and Dispute Resolution</strong></p>
                        <ul>
                        <li>Jurisdiction under which disputes will be resolved.</li>
                        <li>Choice of law and methods for dispute resolution (e.g., arbitration or litigation).</li>
                        </ul>
                        <p><strong>12. Changes to Terms</strong></p>
                        <ul>
                        <li>Explanation of how and when changes to the terms will be made.</li>
                        <li>Notice of changes and instructions for users on accepting or rejecting them.</li>
                        </ul>
                        <p><strong>13. Contact Information</strong></p>
                        <ul>
                        <li>Provide contact details for user inquiries, complaints, or legal matters.</li>
                        </ul>
                        <p><strong>14. Entire Agreement</strong></p>
                        <ul>
                        <li>Statement that these terms represent the entire agreement between the parties, superseding any prior agreements.</li>
                        </ul>
                        <p><strong>15. Severability</strong></p>
                        <ul>
                        <li>Clause stating that if any part of these terms is found to be unenforceable, the rest of the terms remain in effect.</li>
                        </ul>
                        <p><strong>16. Waiver</strong></p>
                        <ul>
                        <li>Statement that failure to enforce any part of these terms does not constitute a waiver of rights.</li>
                        </ul>
                        <p><strong>17. Headings</strong></p>
                        <ul>
                        <li>Clarify that headings are provided for convenience and do not affect the interpretation of the terms.</li>
                        </ul>
                        <p><strong>18. Effective Date</strong></p>
                        <ul>
                        <li>Specify the date when these terms become effective.</li>
                        </ul>';

        $data = [
            [
                'language_id' => 1,
                'title' => $title1,
                'slug' => 'privacy-policy',
                'description' => $description1,
                'meta_title' => $title1,
                'meta_description' => $description1,
            ],
            [
                'language_id' => 1,
                'title' => $title2,
                'slug' => 'terms-and-conditions',
                'description' => $description2,
                'meta_title' => $title2,
                'meta_description' => $description2,
            ],
        ];

        Page::insert($data);
    }
}
