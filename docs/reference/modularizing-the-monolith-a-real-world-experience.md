# Modularizing the monolith: a real-world experience

> Saved from https://mateusguimaraes.com/posts/modularizing-the-monolith-a-real-world-experience
> Author: Mateus Guimarães · Date shown on page: Dec 04, 2027 · Saved: 2026-09-01

Microservices have lots of benefits (and downsides), but one common reason people move away from monoliths is that the project became a big ball of mud, and the thinking that cutting it into several services will fix it (it probably won’t — you’ll have multiple smaller balls of mud).

A nice middle-ground is modular monoliths. Well, what does that mean? It means that you divide your monolith into several mini-apps. I might use the word “Domain”, from DDD, erroneously at this article sometimes.

It is common for us to group things by `Type`. For instance, this would be a common structure for a Laravel project:

```
├── Actions
│   ├── RefundPayment.php
│   ├── CancelCustomerSubscription.php
│   ├── DeleteSite.php
├── QueryBuilders
│   └── SiteQueryBuilder.php
├── Console
│   ├── Commands
│   └── Kernel.php
├── Contracts
│   ├── HasSites.php
│   ├── MakesHttpRequests.php
├── Enums
│   ├── SiteType.php
│   ├── PaymentStatus.php
│   └── UserRole.php
├── Events
│   ├── CustomerCanceledSubscription.php
│   └── CustomerMadePayment.php
│   └── SiteCreated.php
├── Exceptions
│   ├── CouldNotUpdateTwilioDetailsException.php
│   └── Handler.php
├── Facades
│   └── Twilio.php
├── Http
│   ├── Controllers
│   │   ├── Api
│   │   │   ├── SiteController.php
│   │   ├── Controller.php
│   │   ├── DashboardController.php
│   │   ├── InvoiceController.php
│   ├── Kernel.php
│   ├── Livewire
│   ├── Middleware
│   ├── Requests
│   │   ├── StartTrialRequest.php
│   │   └── StoreSiteRequest.php
│   ├── Resources
│   │   ├── UserResource.php
│   │   ├── SiteResource.php
│   │   ├── InvoiceResource.php
├── Jobs
│   ├── UpdateSiteStats.php
│   ├── RefreshInvoice.php
│   ├── UnlockTwilioAccounts.php
├── Listeners
│   ├── AddCustomerToCustomersEmailList.php
│   ├── AddCustomerToTrialEmailList.php
│   ├── RemoveCustomerFromMembersLists.php
│   ├── UpdateSiteDnsRecords.php
│   ├── SendPaymentMadeEmail.php
│   ├── SendSubscriptionCanceledEmail.php
├── Mail
│   ├── PaymentFailedEmail.php
│   ├── PaymentMadeEmail.php
│   ├── RebillNotice.php
├── Models
│   ├── Customer.php
│   ├── Invoice.php
│   ├── Payment.php
├── Notifications
├── Observers
│   ├── SiteObserver.php
├── Policies
├── Providers
├── Rules
├── Services
├── Support
├── Traits
│   ├── HasLicenses.php
│   └── MemoizesValues.php
```

I actually simplified this a lot, but you get the idea — as the app grows, this starts to get very confusing.
For instance, what do `UpdateSiteStats` and `RefreshInvoice` have in common? Nothing, except that they’re both queued jobs — they have the same `Type`. That’s the reason they’re on the same folder — but they don’t share a lot. In fact, they don’t share anything — they belong to two different modules.

With that said, is this organization bad? Not at all. This will work for many — I’d say most — applications, but it’s possible it’ll make things too confusing if your application is too dense. That’s where `modular monoliths` come into play.

A simple way to think of it is that you split your domains — or “modules” — into several mini-applications and (may) implement boundaries between them. Keep in mind this is not a domain-driven design article — it’s simply about splitting your application.

For example, you might have a `Billing` domain that deals with payments, invoices, etc., and also a `Sites` domain, that deals with custom sites for the clients using the service.
Those two might communicate sometimes (for instance, your application might calculate the monthly bill based on the amount of `Sites` a customer has), but overall they’re pretty independent. Here’s what it could look like based on the example I’ve shown earlier:

```
Modules/
├── Billing/
│   ├── Actions/
│   │   └── RefundPayment.php
│   ├── Models/
│   │   ├── Invoice.php
│   │   └── Payment.php
│   ├── Enums/
│   │   └── PaymentStatus.php
│   ├── Events/
│   │   └── PaymentMade.php
│   ├── Exceptions/
│   │   └── PaymentFailedException.php
│   └── Jobs/
│       └── RefreshInvoice.php
└── Sites/
    ├── Actions/
    │   └── DeleteSite.php
    ├── Models/
    │   └── Site.php
    ├── Enums/
    │   └── SiteType.php
    ├── Events/
    │   └── SiteCreated.php
    └── Jobs/
        └── UpdateSiteStatus.php
```

This is a rather simple example but you can see that now things are grouped by `Domain -> Type`. That should make things easier, right?

Well, maybe not so much. Where are the providers, controllers, API resources, mailables, middlewares…? Should migrations still be tangled together with each other in the `database/migrations` folder? What about the views? Do they stay all together?

Okay, so let’s take a break and think about a couple of points.

- Laravel (and most frameworks) allow you to organize your apps however you want. You could keep the “domain stuff” inside the `Modules` folder and the “application stuff” where it usually stays. Or maybe you can treat each module as a mini-application that includes *everything* — migrations, controllers, API resources, tests, your credit card details — or you can be a bit more conservative and leave some things out. It is up to you and there is no right answer.

- This is a very progressive approach. You don’t have to do it all at once — you can move things in small increments, in a way that doesn’t harm your team’s productivity or feature delivery speed.

- As I said, you’re free to organize things as you want. Some people will try to force you that there’s a `correct way` of doing things, but I don’t think there is. You can follow a DDD philosophy and take inspiration from other well-defined architectures, but it is **very unlikely** that you’ll be able to follow anything by the book, especially when working in existing, large projects.

Before we move on, I suggest you add these two articles from Shopify engineering blog to your reading list:

[Deconstructing the Monolith](https://shopify.engineering/deconstructing-monolith-designing-software-maximizes-developer-productivity)

[Under Deconstruction: The State of Shopify’s Monolith — Development](https://shopify.engineering/shopify-monolith)

Spoiler: they made several mini Rails applications inside their main monolithic application.

# Identifying the problem

In the case of the application I was working on, the problem was there was a huge cognitive load to work on a single feature. When I was working on `Billing`, I didn’t really care about `Sites` or `Contacts`. At least not directly.

Besides that, navigating the app was also a bit hard since everything was tangled together. Lots of functionalities were coupled together so maintaining them was a bit harder.

We’re using Eloquent here, so I never expected to decouple features completely — domains are always going to leak through Eloquent models.

The goal was to limit what needed to be touched whenever working on a user story. Is this a `Billing` feature? Okay, cool, I want to see billing-stuff only. Sure, maybe I’ll have to take a plane to `Sitesland` to calculate how much a user should be charged, but that’s a quick trip.

# Tackling down progressively

I did not want to spend a lot of time moving things around, especially because, well, we needed to deliver and fix features.

I started to slowly group things by domain, not caring much about the application layer.

This is not especially hard — it’s just moving things around and changing namespaces — the problem comes down to coupling. More often than not some components depended and maybe were even used by more than one `Thing`. Some methods had weird signatures, `arrays` and destructured data were being passed around, etc.

I want to add one more thing: we had a robust test suite, so that helped make things easier immensely.

I ended up making weekly pull requests to “extract” those modules out of the big ball of mud. I was looking for a couple of things:

- To extract the domain logic

- To refactor things to accept DTOs instead of mysterious data or Eloquent models

- Making sure tests pass after all this

That didn’t give me well-defined boundaries — communication with the **extracted** module was better, yes — but that module would still communicate with the big ball of mud. So it’s something progressive — tough to do at once unless you halt any development.

At this point, the app structure would’ve looked like this:

```
app/
├── Actions/
│   ├── CancelCustomerSubscription.php
│   └── …
├── Console/
│   └── …
├── Contracts
├── Enums/
│   ├── SiteType.php
│   └── …
├── Events
├── Exceptions
├── Http/
│   ├── Controllers/
│   │   ├── InvoiceController.php
│   │   └── …
│   ├── Middleware
│   ├── Requests
│   └── Resources/
│       ├── InvoiceResource.php
│       └── …
└── …
Modules/
└── Billing/
    ├── Actions/
    │   ├── RefundPayment.php
    │   └── CreateInvoice.php
    ├── Models/
    │   ├── Invoice.php
    │   ├── InvoiceItem.php
    │   └── Payment.php
    ├── Contracts/
    │   └── BillableContract.php
    ├── Enums/
    │   └── PaymentStatus.php
    ├── Events/
    │   └── PaymentMade.php
    ├── Exceptions
    ├── Jobs
    └── DataTransferObjects/
        ├── PendingInvoiceDto.php
        ├── InvoiceDto.php
        └── PaymentDto.php
```

So you can see that only the `Domain` of the `Billing` module was extracted.

Could I have extracted the application layer? Yes, but that would’ve made the pull request bigger and more error-prone. Small and progressive was what I was looking for.

You’ll notice that a couple of DTOs were introduced — that made interacting with the `Billing` domain a bit easier. For instance, a job that calculates , makes a payment and generates an invoice could look like this:

```php
<?php
 
namespace App\Jobs;
 
class ChargeUser
{
    public function __construct(
        protected CreateInvoice $createInvoiceAction,
        protected ChargeUser $chargeUserAction
    } {}
 
    public function handle(User $user)
    {
        $sites = $user->sites;
 
        $pendingInvoice = PendingInvoice::make(
            userId: $user->id,
            items: $sites
        );
 
        try {
            $payment = $this->chargeUserAction->handle($pendingInvoice);
        } catch (PaymentFailedException $exception) {
            return;
        }
 
        $this->createInvoiceAction->handle($pendingInvoice, $payment);
    }
}
 
class PendingInvoice
{
    /**
    /* @param int $userId
    /* @param BillableContract[] $items
    */
    public function __construct(
        public int $userId,
        public array $items
    ) {}
 
    public function total(): float
    {
        return array_reduce($this->items, fn (BillableContract $billable) => $billable->total());
    }
}
 
class ChargeUserAction
{
    public function __construct(
        protected PendingInvoice $pendingInvoice,
        protected PaymentProviderContract $paymentProvider
    ) {}
 
    public function handle()
    {
        $providerPayment = $this->paymentProvider->charge($this->pendingInvoice->userId, $this->pendingInvoice->total());
 
        // some logic
        return $payment;
    }
}
 
class CreateInvoiceAction
{
    public function __construct(
        protected PendingInvoice $pendingInvoice,
        protected Payment $payment
    ) {}
 
    public function handle(): Invoice
    {
        $invoice = Invoice::create([
            'total' => $pendingInvoice->total(),
            'payment_id' => $this->payment->id,
            'user_id' => $pendingInvoice->userId
        ]);
 
        $invoice->attachItems($pendingInvoice->items);
 
        return $invoice;
    }
}
```

So as you can see you end up with small, composable actions and structured ways to pass data around. The modules are not **isolated** by any means, but things have their place.

For instance, `User` is not a part of the `Billing` module, and it is still being used — but everything else —, `payments`, `invoices` and the actions, are.

The actions still return Eloquent models, Eloquent relationships are still used and that’s okay. If you want to leverage Eloquent, you have to be okay with things like these.

As you can see, as you migrate each `Thing`to it’s `Module` (or Domain), you still have to refactor some things outside of it, maybe create some actions, but overall it isn’t an extremely hard process.
The key thing here is that you can do this as you go — you’re not required, by any means, to rearchitect the entire application at once. In fact, you don’t even have to move the entire `Domain Layer`(like we did on the example) at once.

## Moving the rest of the module

We basically moved the `Domain Layer` of `Billing`. We still have controllers, requests, API resources, etc. on the `app`folder. and `Migrations` on the `database/migrations` folder.

Moving things such as `Policies`, `Views` `Routing`, and `Migrations` to other places is not as straightforward as moving the domain layer — that’s because you have to instruct Laravel from where it should load those from.

To do that we can use `Service Providers`. Let’s add one inside `Modules/Billing/Providers/BillingServiceProvider.php`

```php
<?php
 
namespace Modules\Billing\Providers;
 
class BillingServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . '../Routes/web.php');
        $this->loadMigrationsFrom(__DIR__ . '../Database/Migrations');
        $this->loadViewsFrom(__DIR__ . '../Views', 'billing');
    }
}
```

That does a couple of things:

- Loads a route file from `Modules/Billing/Routes/web.php`

- Loads migrations from `Modules/Billing/Database/Migrations`

- Loads views from `Modules/Billing/Views`using the `billing` namespace — which means you’d call the view `app.blade.php` as `billing::app`

If you take a look at the last module tree, you’ll see that the `Billing` folder contained, basically, domain code, but it now has other things.

Since we added a routes file, we might as well move controllers, API resources, requests, middleware, etc — the `Application Layer`.
That’d leave us with a bunch of things and it’s starting to get confused once again. That’s a good time to make things even more specific — separate what is `Domain`, `Infrastructure`, and `Application` code.
That gives us something like this:

```
Modules/
└── Billing/
    ├── Domain/
    │   ├── Actions/
    │   │   ├── RefundPayment.php
    │   │   └── CreateInvoice.php
    │   ├── Models/
    │   │   ├── Invoice.php
    │   │   ├── InvoiceItem.php
    │   │   └── Payment.php
    │   ├── Contracts/
    │   │   └── BillableContract.php
    │   ├── Enums/
    │   │   └── PaymentStatus.php
    │   ├── Events/
    │   │   └── PaymentMade.php
    │   ├── Exceptions
    │   ├── Jobs
    │   └── DataTransferObjects/
    │       ├── PendingInvoiceDto.php
    │       ├── InvoiceDto.php
    │       └── PaymentDto.php
    ├── Application/
    │   ├── Http/
    │   │   ├── Controllers/
    │   │   │   └── InvoiceController.php
    │   │   ├── Middleware
    │   │   ├── Requests
    │   │   └── Resources/
    │   │       └── InvoiceResource.php
    │   └── Views/
    │       └── invoices/
    │           └── index.blade.php
    ├── Routes/
    │   └── web.php
    └── Database/
        ├── Migrations
        ├── Factories
        └── Seeders
```

You could also add an `Infrastructure` directory, but for simplicity I only moved the largest ones.
**NOTE**: This is not DDD: this is just us splitting an application into modules.

As you can see, things are now very well segregated. If you needed to work on the `Billing` piece of the application, you shouldn’t have to leave that base directory.

“Oh but I need to charge users for `Contacts` now”. What do I do?

Well, you can see that the jobs accept `PendingInvoiceDto`, which accepts an array of `BillableContract` . Just include those contacts in that array and that’s it — you don’t really have to touch any code inside `Billing`.
Need to add some VAT calculation? Okay, you can do that inside `Billing-World`. No need to look at anything else.

## Going further

We already moved a lot of things, and the `app` folder no longer contains anything directly related to `Billing`. The only missing piece is… tests. The `Billing` tests are still tangled with the rest of our application.

You’re not someone who follows the rules, and you want to have the module’s tests inside the module’s space. How can you do that?
It is surprisingly simple. We can just add a `Modules/Billing/tests` directory and instruct PHPUnit to look there.

```
<?xml version="1.0" encoding="UTF-8"?>
<phpunit xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
         xsi:noNamespaceSchemaLocation="./vendor/phpunit/phpunit/phpunit.xsd"
         bootstrap="vendor/autoload.php"
         colors="true"
>
    <testsuites>
        <testsuite name="Unit">
            <directory suffix="Test.php">./tests/Unit</directory>
        </testsuite>
        <testsuite name="Feature">
            <directory suffix="Test.php">./tests/Feature</directory>
        </testsuite>
    </testsuites>
</phpunit>
```

Once you move everything over you can kill the root `tests`folder and then delete it from `phpunit.xml`.
