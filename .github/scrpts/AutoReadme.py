# -*- coding: utf-8 -*-
__author__ = "Francesco"
__version__ = "0101 2021/11/04"

import os
from pathlib import Path

head, tail = os.path.split(__file__)
os.chdir(head)
percorso = os.getcwd()

# CONSTANT
srcGitDirectory = "https://github.com/deMartiniFrancesco/5BI-DeMartiniFrancesco-2022-2023/tree/master"
readmePath = "/doc/README.md"
# README
intestazioneMD = """# 5BI-DeMartiniFrancesco-2022-2023

"""
lastMD = """## Last

| PROJECT | README |
| :--- | ---: |
"""

projectsMD = """
## Projects

| PROJECT | README |
| :--- | ---: |
"""


def last_project_string(dir_updated):
    string = "| null | null |\n"
    if dir_updated != "":
        top, end = os.path.split(dir_updated)
        src = Path(dir_updated).resolve().parts
        src_name = src[len(src) - 2]
        string = "| " + \
                 "[" + end + "]" + \
                 "(" + srcGitDirectory + "/" + src_name + "/" + end + "/bin)" + \
                 " | " + \
                 "[ReadMe]" + \
                 "(" + srcGitDirectory + "/" + src_name + "/" + end + readmePath + ")" + \
                 " |" + \
                 "\n"
    return string


def projects_string(src_directory, dir_project_name):
    string = ""
    for directory in os.listdir(src_directory):
        src_name = Path(src_directory).resolve().name

        if directory.startswith(dir_project_name):
            string += "| " + \
                      "[" + directory + "]" + \
                      "(" + srcGitDirectory + "/" + src_name + "/" + directory + "/bin)" + \
                      " | " + \
                      "[ReadMe]" + \
                      "(" + srcGitDirectory + "/" + src_name + "/" + directory + readmePath + ")" + \
                      " |" + \
                      "\n"
        else:
            continue
    return string


def write_readme(last_string, project_string):
    try:
        file_readme = open(head + "//README.md", "w")

        file_readme.write(
            intestazioneMD +
            lastMD +
            last_string +
            projectsMD +
            project_string
        )
        file_readme.close()
    except IOError as error:
        print(error)
        return False
    return True


def update_md(src_directory, dir_project_name, dir_updated):
    return write_readme(last_project_string(dir_updated), projects_string(src_directory, dir_project_name))


boold = True
if __name__ == "__main__":
    if boold:
        print("Start")

    print(head)
    
    # update_md(
    #     head + "/src/",
    #     "demartini_F_",
    #     "C:/Users/francesco/Documents/School/5BI-DeMartiniFrancesco-2022-2023/src/demartini_F_Jdbc"
    # )
    if boold:
        print("End")
