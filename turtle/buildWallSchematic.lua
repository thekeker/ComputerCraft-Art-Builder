os.loadAPI("json")
term.clear()
term.setCursorPos(1,1)

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

function refill(chestNum, turtleCurrentWidthPos, turtleCurrentHeightPos)
    -- move back to right topmost corner
    for i=1, turtleCurrentWidthPos-1 do
        turtle.back()
    end

    -- turn to face rear of build and reorient with origin pos
    turtle.turnRight()
    turtle.back()
    turtle.back()
    -- move to chests
    for i=1, turtleCurrentHeightPos do
        turtle.down()
    end

    if chestNum == 1 then
        turtle.turnLeft()
    end
    
    if chestNum == 2 then
        turtle.turnRight()
    end

    turtle.suck()

    if chestNum == 1 then
        turtle.turnRight()
    end
    
    if chestNum == 2 then
        turtle.turnLeft()
    end

    for i=1, turtleCurrentHeightPos do
        turtle.up()
    end

    turtle.forward()
    turtle.forward()
    turtle.turnLeft()
    for i=1, turtleCurrentWidthPos-1 do
        turtle.forward()
    end
    turtle.placeDown()
end

local schematic = getData()

turtle.up()
print("Moving up")

local turtleCurrentWidthPos = 1
local turtleCurrentHeightPos = 1

turtle.forward()
turtle.forward()
turtle.turnLeft()

for i=1, height do    
    for j=1, width do
        
        if schematic[i][j] == 0 then
            turtle.select(1)
        end
        
        if schematic[i][j] == 1 then
            turtle.select(5)        
        end
        
        if not turtle.placeDown() then
            chestNumber = schematic[i][j] + 1
            refill(chestNumber, turtleCurrentWidthPos, turtleCurrentHeightPos)
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
