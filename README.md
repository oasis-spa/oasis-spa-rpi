_**News**_

Created this new repository 
There are four branches for now
1. Master: (Merged with DOCKER branch. Docker branched used as dev for now) Our current working code that was converted to PHP7. Can be run standalone on a RPi 2 - current. OR Docker: Ultimatly the preferred method of deploy. Will come as a platform agnostic docker file that can be updated w/o losing customizations. (Working, but in progress)  See instructions below.
2. php5: Abandoned PHP5 code (not recommended).
3. Rick's original code, PHP5 (not recommended)

The reasoning behind its is that we plan on decoupling the front end PHP from the 'controller' brain. Thus in the future the project will split into two or more seperate repositories. We have big plans for this, but first we'll be getting this original code base up to speed and stable. Further, we're working on a docker image for the project so it can be run on any existing computer/server.

# Oasis-Spa
An MQTT Enabled Hot Tub controller for the Raspberry Pi

The Oasis Spa Controller was built on Rick Feenstra’s excellent project. (http://www.instructables.com/id/Hottub-Pool-Controller-Web-Interface/)  He built it for his own purposes, controlling a traditional Hot Tub with traditional pumps and heater. He built the website which controls the Raspberry Pi’s GPIO pins directly. The functionality is perfect, but I wanted to be able to use wireless IoT switches. Since my tub is an inexpensive inflatable model, and I’m using propane heat, my power requirements don’t get into high-voltage territory. Instead of re-writing the website’s functions to adapt it to MQTT communication we are running a program which listens to the state of the Raspberry’s GPIO pins. If this program detects that a change has been made from ON/OFF it will fire off the appropriate MQTT message to the device associated with that Pin. In this way the website will still function as Rick set it up to do, as well as adding new IoT functionality.

Currently, the process for assigning, and configuring MQTT devices is a manual one. You’ll have to edit the config file yourself for every device you want to add. This functionality is accomplished with the GitHub project: Hallonlarm (https://github.com/hemtjanst/hallonlarm). Your job will be to supply the MQTT Broker address and configure each MQTT device so the program knows how to communicate to/from and which Raspberry BCM pin it should be assigned to. 

_**Oasis Spa**_ is a lightweight Raspberry Pi based Hot Tub controller. Fully configurable with the following features

*  Automatic heating schedules
*  Time based schedules
*  Individual device schedules
*  Trigger Actions based on Temp
*  Overheat monitor 
*  Frost monitor
*  Temperature recording
*  Mobile optimized interface
*  MQTT device control
*  Based on a vanilla RPi Stretch
*  Standard GPIO control of anything a Raspberry Pi can access
*  Unlimited temperature sensors
*  Configurable views on the main page
*  Tablet optimized page
*  HTTP API for device/site/tub control

## Docker
Install docker using [the convenience script](https://docs.docker.com/install/linux/docker-ce/debian/#install-using-the-convenience-script).

Add the pi user to the docker group `sudo usermod -aG docker pi`

Install docker-compose
```
sudo apt-get update && sudo apt-get install -y --no-install-recommends docker-compose
```

Read more: https://docs.docker.com/install/linux/docker-ce/debian/

### Run with docker-compose
/* This is the recommended approach.

Copy or rename [default.env](default.env) to `.env`.

```
docker-compose up -d --build
```

### Build with Docker
From this repo `docker build -t oasis .`

Set up the database with `init` command
```
docker run --rm -ti -v mysqldata:/var/lib/mysql --device /dev/gpiomem oasis init
```

To run on pi 
```
docker run --rm -ti -p80:80 -vmysqldata:/var/lib/mysql --device /dev/gpiomem -v `pwd`:/var/www/html -d --name oasis oasis start
```

Logs
```
docker logs -f oasis
```
