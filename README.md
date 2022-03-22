# Magento
For Feedback Module

For SMTP I used ->  composer require magepal/magento2-gmailsmtapp

Task 1:
1. Display customer feedback link at footer
2. Display the form in the customer feedback landing page and form will have the below fields
        1. Customer first name. 2. last name, 3. email, 4. Comment text area
3. Magento form validation
4. Once customer submit the feedback redirect them to home page and display success message in message box.
5. In admin panel to display "Customer Feedback" tab under customer menu
6. Display the list of submitted feedback in grid view with sort, search, pagination

Task 2:
1. If admin click Approve button will send email to customer saying your feedback has approved, if admin click Decline button email should be sent as decline message.
2. Display the status column in admin grid
3. Display the approved feedback in home page with scroller. Each feedback should be placed in one scroller 

Task 3:
1. If logged customer to get the 1. Customer firstname. 2. lastname, 3. email from customer account and populate in the form
2. Once customer submits the form send the email to customer and bcc to store admin (get the store admin email from configuration)
3. In admin grid display view link for each record
4. Once the view link is clicked, display the record in landing page with the Approve and Decline button in the top
