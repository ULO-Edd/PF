<?php

use yii\db\Migration;

/**
 * Class m211029_174815_init_rbac
 */
class m211029_174815_init_rbac extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $auth = Yii::$app->authManager;

        // Sugestões / Reports
        $createSuggestion = $auth->createPermission('createSuggestion');
        $createSuggestion->description = 'Create a Suggestion';
        $auth->add($createSuggestion);

        $seeSuggestion = $auth->createPermission('seeSuggestion');
        $seeSuggestion->description = 'See Suggestion';
        $auth->add($seeSuggestion);

        $deleteSuggestion = $auth->createPermission('deleteSuggestion');
        $deleteSuggestion->description = 'Delete Suggestion';
        $auth->add($deleteSuggestion);

        // Favoritos
        $createFavorites = $auth->createPermission('createFavorite');
        $createFavorites->description = 'Create Favorite';
        $auth->add($createFavorites);

        $seeFavorites = $auth->createPermission('seeFavorites');
        $seeFavorites->description = 'See Favorites';
        $auth->add($seeFavorites);

        $deleteFavorites = $auth->createPermission('deleteFavorites');
        $deleteFavorites->description = 'Delete Favorites';
        $auth->add($deleteFavorites);

        // Atividades Ticket
        $createTicketActivities = $auth->createPermission('createTicketActivities');
        $createTicketActivities->description = 'Create Ticket Activities';
        $auth->add($createTicketActivities);

        $seeTicketActivities = $auth->createPermission('seeTicketActivities');
        $seeTicketActivities->description = 'See Ticket Activities';
        $auth->add($seeTicketActivities);

        $deleteTicketActivities = $auth->createPermission('deleteTicketActivities');
        $deleteTicketActivities->description = 'Delete Ticket Activities';
        $auth->add($deleteTicketActivities);

        // tipo de Atividades
        $createActivityType = $auth->createPermission('createActivityType');
        $createActivityType->description = 'Create Activity Type';
        $auth->add($createActivityType);

        $seeActivityType = $auth->createPermission('seeActivityType');
        $seeActivityType->description = 'See Activity Type';
        $auth->add($seeActivityType);

        $editActivityType = $auth->createPermission('editActivityType');
        $editActivityType->description = 'Edit Activity Type';
        $auth->add($editActivityType);

        $deleteActivityType = $auth->createPermission('deleteActivityType');
        $deleteActivityType->description = 'Delete Activity Type';
        $auth->add($deleteActivityType);

        // Atividades
        $createActivity = $auth->createPermission('createActivity');
        $createActivity->description = 'Create Activity';
        $auth->add($createActivity);

        $seeActivity = $auth->createPermission('seeActivity');
        $seeActivity->description = 'See Activity';
        $auth->add($seeActivity);

        $editActivity = $auth->createPermission('editActivity');
        $editActivity->description = 'Edit Activity';
        $auth->add($editActivity);

        $deleteActivity = $auth->createPermission('deleteActivity');
        $deleteActivity->description = 'Delete Activity';
        $auth->add($deleteActivity);

        // Tickets
        $createTicket = $auth->createPermission('createTicket');
        $createTicket->description = 'Create Ticket';
        $auth->add($createTicket);

        $seeTicket = $auth->createPermission('seeTicket');
        $seeTicket->description = 'See Ticket';
        $auth->add($seeTicket);

        $deleteTicket = $auth->createPermission('deleteTicket');
        $deleteTicket->description = 'Delete Ticket';
        $auth->add($deleteTicket);

        //Novidades
        $createNews = $auth->createPermission('createNews');
        $createNews->description = 'Create News';
        $auth->add($createNews);

        $seeNews = $auth->createPermission('seeNews');
        $seeNews->description = 'See News';
        $auth->add($seeNews);

        $editNews = $auth->createPermission('editNews');
        $editNews->description = 'Edit News';
        $auth->add($editNews);

        $deleteNews = $auth->createPermission('deleteNews');
        $deleteNews->description = 'Delete News';
        $auth->add($deleteNews);

        //Users
        $createUser = $auth->createPermission('createUser');
        $createUser->description = 'Create User';
        $auth->add($createUser);

        $seeUser = $auth->createPermission('seeUser');
        $seeUser->description = 'See User';
        $auth->add($seeUser);

        $editUser = $auth->createPermission('editUser');
        $editUser->description = 'Edit User';
        $auth->add($editUser);

        $deleteUser = $auth->createPermission('deleteUser');
        $deleteUser->description = 'Delete User';
        $auth->add($deleteUser);

        //Eventos
        $createEvents = $auth->createPermission('createEvents');
        $createEvents->description = 'Create Events';
        $auth->add($createEvents);

        $seeEvents = $auth->createPermission('seeEvents');
        $seeEvents->description = 'See Events';
        $auth->add($seeEvents);

        $editEvents = $auth->createPermission('editEvents');
        $editEvents->description = 'Edit Events';
        $auth->add($editEvents);

        $deleteEvents = $auth->createPermission('deleteEvents');
        $deleteEvents->description = 'Delete Events';
        $auth->add($deleteEvents);

        //Patrocinios
        $createSponsors = $auth->createPermission('createSponsors');
        $createSponsors->description = 'Create Sponsors';
        $auth->add($createSponsors);

        $seeSponsors = $auth->createPermission('seeSponsors');
        $seeSponsors->description = 'See Sponsors';
        $auth->add($seeSponsors);

        $editSponsors = $auth->createPermission('editSponsors');
        $editSponsors->description = 'Edit Sponsors';
        $auth->add($editSponsors);

        $deleteSponsors = $auth->createPermission('deleteSponsors');
        $deleteSponsors->description = 'Delete Sponsors';
        $auth->add($deleteSponsors);

        //Lojas
        $createStores = $auth->createPermission('createStores');
        $createStores->description = 'Create Stores';
        $auth->add($createStores);

        $seeStores = $auth->createPermission('seeStores');
        $seeStores->description = 'See Stores';
        $auth->add($seeStores);

        $editStores = $auth->createPermission('editStores');
        $editStores->description = 'Edit Stores';
        $auth->add($editStores);

        $deleteStores = $auth->createPermission('deleteStores');
        $deleteStores->description = 'Delete Stores';
        $auth->add($deleteStores);

        //Produtos Loja
        $createProductStore = $auth->createPermission('createProductStore');
        $createProductStore->description = 'Create ProductStore';
        $auth->add($createProductStore);

        $seeProductStore = $auth->createPermission('seeProductStore');
        $seeProductStore->description = 'See ProductStore';
        $auth->add($seeProductStore);

        $editProductStore = $auth->createPermission('editProductStore');
        $editProductStore->description = 'Edit ProductStore';
        $auth->add($editProductStore);

        $deleteProductStore = $auth->createPermission('deleteProductStore');
        $deleteProductStore->description = 'Delete ProductStore';
        $auth->add($deleteProductStore);

        // Roles
        $client = $auth->createRole('client');
        $auth->add($client);

        $manager = $auth->createRole('manager');
        $auth->add($manager);

        $admin = $auth->createRole('admin');
        $auth->add($admin);

        // Permissions
        // Assert Parents
        $auth->addChild($admin, $manager);

        // Permissions to client
        $auth->addChild($client, $createSuggestion);
        $auth->addChild($client, $createTicket);
        $auth->addChild($client, $seeTicket);
        $auth->addChild($client, $deleteTicket);
        $auth->addChild($client, $seeNews);
        $auth->addChild($client, $seeActivity);
        $auth->addChild($client, $createFavorites);
        $auth->addChild($client, $seeFavorites);
        $auth->addChild($client, $deleteFavorites);
        $auth->addChild($client, $createTicketActivities);
        $auth->addChild($client, $seeTicketActivities);
        $auth->addChild($client, $deleteTicketActivities);
        $auth->addChild($client, $seeEvents);
        $auth->addChild($client, $seeSponsors);
        $auth->addChild($client, $seeStores);
        $auth->addChild($client, $seeProductStore);

        // Permissions to manager
        $auth->addChild($manager, $createActivity);
        $auth->addChild($manager, $seeActivity);
        $auth->addChild($manager, $editActivity);
        $auth->addChild($manager, $deleteActivity);
        $auth->addChild($manager, $createActivityType);
        $auth->addChild($manager, $seeActivityType);
        $auth->addChild($manager, $editActivityType);
        $auth->addChild($manager, $deleteActivityType);
        $auth->addChild($manager, $createNews);
        $auth->addChild($manager, $seeNews);
        $auth->addChild($manager, $editNews);
        $auth->addChild($manager, $deleteNews);
        $auth->addChild($manager, $seeSuggestion);
        $auth->addChild($manager, $deleteSuggestion);
        $auth->addChild($manager, $createEvents);
        $auth->addChild($manager, $seeEvents);
        $auth->addChild($manager, $editEvents);
        $auth->addChild($manager, $deleteEvents);
        $auth->addChild($manager, $createProductStore);
        $auth->addChild($manager, $seeProductStore);
        $auth->addChild($manager, $editProductStore);
        $auth->addChild($manager, $deleteProductStore);
        $auth->addChild($manager, $seeStores);
        $auth->addChild($manager, $createSponsors);
        $auth->addChild($manager, $seeSponsors);
        $auth->addChild($manager, $editSponsors);
        $auth->addChild($manager, $deleteSponsors);

        // Permissions to admin
        $auth->addChild($admin, $createUser);
        $auth->addChild($admin, $seeUser);
        $auth->addChild($admin, $editUser);
        $auth->addChild($admin, $deleteUser);
        $auth->addChild($admin, $seeTicket);
        $auth->addChild($admin, $deleteTicket);
        $auth->addChild($admin, $createStores);
        $auth->addChild($admin, $editStores);
        $auth->addChild($admin, $deleteStores);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m211029_174815_init_rbac cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m211029_174815_init_rbac cannot be reverted.\n";

        return false;
    }
    */
}