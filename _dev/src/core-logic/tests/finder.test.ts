import { BlockContent } from "../entities/BlockContent";
import filledColumnContent from "./filledColumnContentWithId.json";
import { findComponentById } from "../utils/finder";

describe("Component finder", () => {
  let blockContent: BlockContent;
  beforeAll(() => {
    blockContent = filledColumnContent as BlockContent;
  });

  it("finds block id", () => {
    const component = findComponentById(blockContent, "block_id");
    expect(component.node.id).toEqual("block_id");
    expect(component.parent).toBeUndefined();
  });

  it("finds a component", () => {
    const component = findComponentById(blockContent, "field_0");
    expect(component.node.id).toEqual("field_0");
  });

  it("gives block id as parent for 1st level component search", () => {
    const component = findComponentById(blockContent, "field_0");
    expect(component.parent.id).toEqual("block_id");
  });

  it("finds a repeatable component", () => {
    const component = findComponentById(blockContent, "field_2_0");
    expect(component.node.id).toEqual("field_2_0");
  });

  it("gives repeater id as parent for repeated component search", () => {
    const component = findComponentById(blockContent, "field_2_0");
    expect(component.parent.id).toEqual("field_2");
  });

  it("finds a recursively nested component", () => {
    const component = findComponentById(blockContent, "field_2_1_1_0_0");
    expect(component.node.id).toEqual("field_2_1_1_0_0");
  });

  it("gives right repeater id as parent for nested component search", () => {
    const component = findComponentById(blockContent, "field_2_1_1_0_0");
    expect(component.parent.id).toEqual("field_2_1_1_0");
  });
});
