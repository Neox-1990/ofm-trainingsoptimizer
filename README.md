# ofm-trainingsoptimizer
A little PHP skript / framework for calculating the best training for the german browsergame "Online Fußball Manager", working for Firefox and Chrome

The script includes also part that calculates the AWPs and got a calculator for the transfermarket.

The calculation is done with a simple per day optimization on TP for the hole team
The Input works by simple copy and paste, but is unstable with "unclean" copy and paste.

For train: copy the team in the train-view, but without the first checkbox

For transfermarket: copy the players you want the awp from, you can additional add EP+ and TP+ (for posible AWP with tournament and train-camps)

For AWP update: you have to update the AWP table (.txt) to keep the AWP-Calculation with the corresponding level correct. Do it manually or with the form. With the form just open the "AWP-Rechner" of OFM, then go to tab "Aufwertungsgrenzen" and there copy everything into the form (ctrl+a, ctrl+c, ctrl+v).

The Indexfile shows how to build up the setup for the calculation. It got some passwordprotection which you can change or disable if you like to.

For more information, just contact me.
