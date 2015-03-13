## PolyGame ##
At the beginning we have to provide:
  * ~~a login page~~
  * ~~a common visual element with the indication of the game phase and the time left~~

## Players ##
~~Create the main page for the player~~
### Wedge-Study Phase ###
  * ~~The page should display the information, adding more documents and links as the time goes on~~
  * ~~When the time is over the right values should be shown to the players~~
  * ~~At the end of this phase the player should produce a poster with the pros and the cons of their wedge~~
  * ~~Decide what is the format of a poster~~
  * ~~Make the form to input the data (And decide where it is better to store it)~~
  * ~~Allow users to insert just one poster.~~ ~~If there is already a poster the player is asked to edit it and not to insert a new one.~~
  * ~~Users can check their solution with the values provided by the instructors.~~
  * ~~Add a link to come back to the wedge information page~~
  * ~~When the phase one is over the system should take the users to the phase two~~

### Plan-Selection Phase ###
  * ~~We have to provide an interactive table to each team, in order to make them able to create their own mix. The table should show what is going on when a wedge is selected.~~
  * ~~Users should be able to delete the submitted plan and to create a new one.~~ EXTRA Update instead of drop.
  * ~~Users should be able to view the documents produced in the previous page to make their choices~~

## Game organizer ##
  * ~~TODO: don't remove players involved in a game!~~
  * ~~only one game per organizer (yes, this is not a feature)~~
  * ~~cooooool, now organizers can organize from different computer on different browsers... their session is recreated everytime the organizer.php is loaded up~~
  * ~~see all players in the database~~
  * ~~remove selected players from database~~
  * ~~add players to database~~
  * ~~see players associated to current game~~
  * ~~delete selected players associated to current game~~
  * ~~add incrementally players to current game~~
  * ~~new game created everytime organizer click on "create game"~~
  * ~~organizer page changes depending on the current phase of game~~
  * ~~organizer can make the game start hitting a button~~
  * ~~deleting current game actually deletes all possible games and wedges and game players associated to an organizer: database will be cleaner!!~~
  * ~~organizer.php calculates correctly phase of the game~~
  * ~~organizer.php refreshes in order to show a rudimentary timer~~
  * ~~Select the users and the wedges that are part of the game~~
  * They eventually may have to locally edit or create a new wedge
  * ~~They may give some extra time to the players~~
  * ~~They should have an overview of the state of the game, in order to know whats going on~~
  * ~~They should create, list, delete, choose the voters~~
  * ~~Button "Start phase 1" and "Start phase 2"~~
  * ~~Handle players associated to different phases~~

## Voters ##
  * ~~They have to look at the different solution in order to find the winner of the game~~
  * In this perspective other parameters should be introduced, to make the decision based on something more than the mere CO2 reduction data. Pareto analysis may come in hand at this point

## Administrator ##
  * He has to setup the system
  * He can edit the global data and add new wedges available in all the games
  * ~~He can create the game organizers~~

TODO: Check that all the inputs are validated (For example in newGame)
  * ~~link per tornare indietro dalla pagina delle soluzioni~~
  * ~~aggiungere i dati (section 3) assieme all'introduzione~~
  * ~~pro e cons dai poster~~
  * mostrare conti se la soluzione e' corretta
  * localizzazione wedge
  * ~~20 e' il limite minimo. 20 Deve essere modificabile~~
  * ~~Fix char encoding~~
  * ~~Pulire bene tutto il database~~
  * ~~tornare al menú dopo avere assegnato i wedges agli utenti~~
  * ~~eliminare results.php~~
  * ~~aggiungere bottone per uscire dalla showWedgeInfromations~~
  * ~~Aggiungere tabellina con stato dei wedges per dare all'organizzatore un overview del gioco~~
  * ~~Presentazione dei poster~~
  * ~~Regole del gioco~~
  * ~~presentazione dei wedges~~
  * ~~Motivazione del voto~~
  * ~~Link alla tabella condivisa dei dati~~
  * ~~Sistemare tempo aggiuntivo in fase 2~~
  * ~~togliere i millisecondi dal timer~~
  * ~~Tornare alla fase precedente~~
  * ~~tempo in meno >>> andare a fase successiva~~
  * ~~controlli prima di start phase 1: no giocatori, giocatori senza wedge, gruppi senza wedge~~ >>> viene mostrato un resoconto dello stato delle selezioni
  * ~~impedire inserimento lettere in creazione gioco~~
  * gestire underscore: non accettarlo in input e metterlo nel db
  * ~~formattazione testo nel poster~~

# TO DO #

## After meeting with Casagrandi ##
  * inserimento dati da file
  * ~~togliere SQL da insert new wedge~~
  * help
  * ~~modificare user in groups in organize.php~~
  * aggiornare valore del plan con update tabe: we decided for/because
  * mettere a disposizione presentazione per voter
  * ~~figure nel poster~~ >>> provide link!
  * ~~ordine operazioni organizer~~
  * remove wedge and groups
  * remove user from group when it is removed from the game
  * ~~aggiungere giocatori singoli alla ricapitolazione~~
  * description of the game in the homepage

## After Xmas holiday ##
  * keep an eye on newGroup.php and rulesAndPlayers.php
  * rename insert button in "editWedge" to "UPDATE", add "cancel", etc..-
  * page to delete organizers
  * fill in the questions in login.php
  * credits page... maybe it's better to put it since casagrandi has asked for it. I think it would be cool to follow an informal approach and put only the name (maybe with a picture).

## Facoltativi ##
  * unificare add/delete wedge e add/delete organizer nella schermata admin

## **For Marko** ##
  * **all pages**
    * there are some fount issue. The HelveticaNeue LT font isn't standard nor it is installed on all the operating systems. This means that the text is rendered in Times New Roman rather than the chosen font.
    * the style for the links specifies the same color for the text and for the background when the mouse is over the link, making the text unreadable when the link is selected.
    * in many pages there's a bit of unneeded code. For instance often we see{{{
<p>&nbsp;</p>
>  <p>&nbsp;</p>
>  <p>&nbsp;</p>
>  <p>&nbsp;</p>
>  <p>&nbsp;</p>
}}} Could you please clean that?
    * the mentioned problem causes A LOT of extra spaces in the webpages
    * the background sometimes makes the page less readable. We know it's hard, but could you please think of something that doesn't alter readability?
    * "you must login as.. to perform this..." pages have NO graphics
    * many pages have the title "Untitled Document"
  * **editWedge**: when the administrator modifies a wedge the "update" button is UNDER the animation. Could you please move it ABOVE?
  * **showWedges** there is just the list of the wedges. It isn't formatted
  * **assignWedges**: text that appears while handling the menus is not centered
  * **organize**: make timer bigger and more beautiful!
  * many links do not belong to any class and for this reason they're rendered with the default font, size and color. This happens for example in the organizer page, during a game for the links "Go to previous phase" and "Go to next phase"