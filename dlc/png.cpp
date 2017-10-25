#include "lodepng.h"
// ^^^ found on http://lodev.org/lodepng/ ^^^ used to encode PNG files
#include <fstream>
#include <iostream>

void encodeOneStep(const char* filename, std::vector<unsigned char>& image, unsigned width, unsigned height)
{
  //Encode the image
  unsigned error = lodepng::encode(filename, image, width, height);

  //if there's an error, display it
  if(error) std::cout << "encoder error " << error << ": "<< lodepng_error_text(error) << std::endl;
}

void darkdirt(std::vector<unsigned char>& img, unsigned x, unsigned y, unsigned w, unsigned h) {
  img[4*w*y + 4*x+0] = 137; // R
  img[4*w*y + 4*x+1] = 93; // G
  img[4*w*y + 4*x+2] = 82; // B
  img[4*w*y + 4*x+3] = 255; // Alpha
}

void lightdirt(std::vector<unsigned char>& img, unsigned x, unsigned y, unsigned w, unsigned h) {
  img[4*w*y + 4*x+0] = 186;
  img[4*w*y + 4*x+1] = 126;
  img[4*w*y + 4*x+2] = 111;
  img[4*w*y + 4*x+3] = 255;
}

void lightgrass(std::vector<unsigned char>& img, unsigned x, unsigned y, unsigned w, unsigned h) {
  img[4*w*y + 4*x+0] = 0;
  img[4*w*y + 4*x+1] = 255;
  img[4*w*y + 4*x+2] = 0;
  img[4*w*y + 4*x+3] = 255;
}

void darkgrass(std::vector<unsigned char>& img, unsigned x, unsigned y, unsigned w, unsigned h) {
  img[4*w*y + 4*x+0] = 93;
  img[4*w*y + 4*x+1] = 203;
  img[4*w*y + 4*x+2] = 80;
  img[4*w*y + 4*x+3] = 255;
}

void forest(std::vector<unsigned char>& img, unsigned x, unsigned y, unsigned w, unsigned h) {
  img[4*w*y + 4*x+0] = 34;
  img[4*w*y + 4*x+1] = 135;
  img[4*w*y + 4*x+2] = 23;
  img[4*w*y + 4*x+3] = 255;
}

void partialforest(std::vector<unsigned char>& img, unsigned x, unsigned y, unsigned w, unsigned h) {
  img[4*w*y + 4*x+0] = 17;
  img[4*w*y + 4*x+1] = 169;
  img[4*w*y + 4*x+2] = 0;
  img[4*w*y + 4*x+3] = 255;
}

void rock(std::vector<unsigned char>& img, unsigned x, unsigned y, unsigned w, unsigned h) {
  img[4*w*y + 4*x+0] = 96;
  img[4*w*y + 4*x+1] = 96;
  img[4*w*y + 4*x+2] = 96;
  img[4*w*y + 4*x+3] = 255;
}

void partialrock(std::vector<unsigned char>& img, unsigned x, unsigned y, unsigned w, unsigned h) {
  img[4*w*y + 4*x+0] = 160;
  img[4*w*y + 4*x+1] = 160;
  img[4*w*y + 4*x+2] = 160;
  img[4*w*y + 4*x+3] = 255;
}

void deepwater(std::vector<unsigned char>& img, unsigned x, unsigned y, unsigned w, unsigned h) {
  img[4*w*y + 4*x+0] = 0;
  img[4*w*y + 4*x+1] = 102;
  img[4*w*y + 4*x+2] = 204;
  img[4*w*y + 4*x+3] = 255;
}

void lightwater(std::vector<unsigned char>& img, unsigned x, unsigned y, unsigned w, unsigned h) {
  img[4*w*y + 4*x+0] = 0;
  img[4*w*y + 4*x+1] = 255;
  img[4*w*y + 4*x+2] = 255;
  img[4*w*y + 4*x+3] = 255;
}

int main(int argc, char** argv) {
  const char* fileout = argc==3?argv[1]:"/Users/marco/Desktop/test.png";
  const char* filein =  argc==3?argv[2]:"/Users/marco/Desktop/test.map";

  std::ifstream map(filein);

  std::string name, line;
  std::getline(map,line); // useless line "# Map Name"
  std::getline(map,name); // map name

  std::getline(map,line); // useless line "# Map Dimensions W x H"

  unsigned w,h;
  map >> w >> h; // get width, height


  std::getline(map,line); // I think this is a newline
  std::getline(map,line); // Which means I guess this is "# Map Terrain Data"

  std::vector<unsigned char> image;
  image.resize(w*h*4);

  for (unsigned y = 0; y<h; ++y) {
    std::getline(map,line);

    for (unsigned x = 0; x<w; ++x) {
      char t = line[x];
      switch(t) {
        case 'd':
          lightdirt(image,x,y,w,h);
          break;
        case 'D':
          darkdirt(image,x,y,w,h);
          break;
        case 'r':
          partialrock(image,x,y,w,h);
          break;
        case 'R':
          rock(image,x,y,w,h);
          break;
        case 'f':
          partialforest(image,x,y,w,h);
          break;
        case 'F':
          forest(image,x,y,w,h);
          break;
        case 'g':
          lightgrass(image,x,y,w,h);
          break;
        case 'G':
          darkgrass(image,x,y,w,h);
          break;
        case 'w':
          lightwater(image,x,y,w,h);
          break;
        case 'W':
          deepwater(image,x,y,w,h);
          break;
        default:
          std::cout << "Uh oh we hit an unexpected character: " << t << '\n';
      }
    }
  }

  std::getline(map,line); // # Map Partial Info or something like that
  for (int i=0; i<=h+1; ++i) {
    std::getline(map,line);
  } // throw away the map partial info or whatever


  std::getline(map,line); // # Map Num Players or something like that
  std::string numPlayers = "-1";
  map >> numPlayers; // get number of players

  encodeOneStep(fileout,image,w,h);

  std::cout << numPlayers << name;
}
