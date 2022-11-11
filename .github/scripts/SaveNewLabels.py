# -*- coding: utf-8 -*-
__author__ = "Francesco"
__version__ = "0101 2022/11/09"

import os

head, tail = os.path.split(__file__)
os.chdir(head)
os.chdir("../..")
os.chdir(os.getcwd())

label_path = ".github/labeler.yml"
dir_project_name = "demartini_F_"
src_path = "src/main/java/deMartiniFrancesco/projects"

default_label = \
    """documentation:
  - README.md

test:
  - src/test/java/*

library:
  - lib/*

workflows:
  - .github/workflows/*

resources:
  - src/main/resources/*

"""


def write_labels(label_strings: str):
    try:
        file_labels = open(label_path, "w")

        file_labels.write(
            default_label +
            label_strings
        )
        file_labels.close()

    except IOError as error:
        print(error)
        return False
    return True


def labels_string(list_directory_name: list):
    string = ""
    directory: str
    for directory in list_directory_name:
        string += directory.replace(dir_project_name, "") + ":\n  - " + src_path + "/" + directory + "/*\n\n"
    return string


boold = True
if __name__ == '__main__':
    if boold:
        print("Start")

    list_dir = os.environ.get("INPUT_LIST").split("?")

    print(list_dir, type(list_dir))

    print ("Write: " + write_labels(labels_string(list_dir)))

    if boold:
        print("End")
