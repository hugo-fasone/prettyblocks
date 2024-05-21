import { BlockContent } from "../entities/BlockContent";
import { BlockStructure } from "../entities/BlockStructure";
import { ComponentContent } from "../entities/ComponentContent";
import { PrimitiveFieldType } from "../entities/ElementType";
import { Repeater } from "../entities/Repeater";
import columnStructure from "./columnStructure.json";
import { createTestingPinia } from "@pinia/testing";
import { setActivePinia } from "pinia";
import { useZoneStore } from "../store/zoneStore";

describe("Add Component", () => {
  const newColumnBlock: BlockContent = {
    id: "some_random_id",
    block_id: "columnBlock",
    fields: [
      {
        id: "some_random_id",
        type: "text" as PrimitiveFieldType.TEXT,
        label: "Column block title",
        content: {
          value: "Column title",
        },
      },
      {
        id: "some_random_id",
        component_id: "banner",
        type: "component",
        label: "Banner",
        fields: [
          {
            id: "some_random_id",
            type: "text" as PrimitiveFieldType.TEXT,
            label: "Image",
            content: {
              value: "BannerImage",
            },
          },
          {
            id: "some_random_id",
            type: "text" as PrimitiveFieldType.TEXT,
            label: "Intro",
            content: {
              value: "Wonderful intro",
            },
          },
        ],
      },
      {
        id: "columnComponentId",
        component_id: "column",
        type: "repeater",
        label: "Columns",
        sub_elements: [],
      },
    ],
  };

  beforeEach(() => {
    const pinia = createTestingPinia({
      initialState: {
        zone: {
          availableBlocks: [columnStructure as BlockStructure],
          content: [newColumnBlock],
        },
      },
    });
    setActivePinia(pinia);
  });

  it("does not change state if component does not exist", () => {
    const zoneStore = useZoneStore();
    expect(
      (zoneStore.content[0].fields[2] as Repeater<ComponentContent>)
        .sub_elements
    ).toHaveLength(0);
    zoneStore.addComponent(0, "undefinedId");
    expect(
      (zoneStore.content[0].fields[2] as Repeater<ComponentContent>)
        .sub_elements
    ).toHaveLength(0);
  });

  it("adds a new component at indicated place", () => {
    const zoneStore = useZoneStore();
    zoneStore.addComponent(0, "column");
    expect(
      (zoneStore.content[0].fields[2] as Repeater<ComponentContent>)
        .sub_elements
    ).toHaveLength(1);
  });

  it("adds component fields to new component", () => {});

  it("adds component after existing components", () => {});

  it("adds sub-components", () => {});
});
