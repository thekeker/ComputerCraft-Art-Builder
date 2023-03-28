os.loadAPI("json")
term.clear()
term.setCursorPos(1,1)

local fuelSlot = 16
local firstBlockSlot = 1
local secondBlockSlot = 5
local thirdBlockSlot = 9
local fourthBlockSlot = 13

print("Please enter your Schematic ID.")
local schematicId = read()
print("Enter Width")
local width = read()
print("Enter Height")
local height = read()
if height == nil then
    height = width
end

local url = "http://10.0.0.156/turtle-img-builder/turtle.php?id=" .. schematicId

function getData()
    local data = http.get(url)
    local webData = data.readAll()
    local schematicObject = json.decode(webData)
    data.close()
    return schematicObject
end

function repeatCmd(command, amount)
    local func = loadstring(command)
    for i=1, amount do
        func()
    end
end

function refill(turtleCurrentWidthPos, turtleCurrentHeightPos)
    local currentBlockSlot = turtle.getSelectedSlot()

    local blocksToFillFuel = turtle.getItemSpace(fuelSlot)
    local blocksToFillFirstBlock = turtle.getItemSpace(firstBlockSlot)
    local blocksToFillSecondBlock = turtle.getItemSpace(secondBlockSlot)
    local blocksToFillThirdBlock = turtle.getItemSpace(thirdBlockSlot)
    local blocksToFillFourthBlock = turtle.getItemSpace(fourthBlockSlot)
    
    -- move back to right topmost corner
    for i=1, turtleCurrentWidthPos-1 do
        turtle.back()
    end

    -- turn to face rear of build and reorient with origin pos
    turtle.turnRight()
    repeatCmd("turtle.back()", 2)

    -- move to chests
    for i=1, turtleCurrentHeightPos do
        turtle.down()
    end

    -- fill fuel slot if required
    if blocksToFillFuel > 0 then
        turtle.up()
        repeatCmd("turtle.turnRight()", 2)
        turtle.select(firstBlockSlot)
        turtle.suck(blocksToFillFuel)
        repeatCmd("turtle.turnRight()", 2)
        turtle.down()
        print("out of fuel blocks")
    end

    -- fill first block slot if required
    if blocksToFillFirstBlock > 0 then
        turtle.select(firstBlockSlot)
        turtle.suck(blocksToFillFirstBlock)
    end

    -- orient to next slot
    turtle.turnRight()

    -- fill second block slot if required
    if blocksToFillSecondBlock > 0 then
        turtle.select(secondBlockSlot)
        turtle.suck(blocksToFillFirstBlock)
    end

    -- orient to next slot
    turtle.turnRight()

    -- fill third block slot if required
    if blocksToFillThirdBlock > 0 then
        turtle.select(thirdBlockSlot)
        turtle.suck(blocksToFillFirstBlock)
    end

    -- orient to next slot
    turtle.turnRight()

    -- fill fourth block slot if required
    if blocksToFillFourthBlock > 0 then
        turtle.select(fourthBlockSlot)
        turtle.suck(blocksToFillFirstBlock)
    end

    -- orient to origin
    turtle.turnRight()

    -- moves away from chests and continues building
    for i=1, turtleCurrentHeightPos do
        turtle.up()
    end
    repeatCmd("turtle.forward()", 2)
    turtle.turnLeft()
    for i=1, turtleCurrentWidthPos-1 do
        turtle.forward()
    end
    turtle.select(currentBlockSlot)
end

local schematic = getData()

turtle.up()
print("Starting build... Kick back and relax")

local turtleCurrentWidthPos = 1
local turtleCurrentHeightPos = 1

turtle.forward()
turtle.forward()
turtle.turnLeft()

-- code that places the blocks
for i=1, height do    
    for j=1, width do

        while turtle.getFuelLevel() < minimumFuel do
            if not turtle.refuel(fuelSlot) then
                refill(turtleCurrentWidthPos,turtleCurrentHeightPos)
            end
        end

        if schematic[i][j] == 0 then
            turtle.select(firstBlockSlot)
        end
        
        if schematic[i][j] == 1 then
            turtle.select(secondBlockSlot)        
        end

        if schematic[i][j] == 2 then
            turtle.select(thirdBlockSlot)        
        end

        if schematic[i][j] == 3 then
            turtle.select(fourthBlockSlot)        
        end
        
        if not turtle.placeDown() then
            refill(turtleCurrentWidthPos, turtleCurrentHeightPos)
            turtle.placeDown()
        end

        turtle.forward()
        turtleCurrentWidthPos = turtleCurrentWidthPos + 1
    end
    
    turtle.up()
    turtleCurrentHeightPos = turtleCurrentHeightPos + 1

    for i=1, width do
        turtle.back()
        turtleCurrentWidthPos = 1
    end
end
